<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Structure;

use BDP\Telegram\Command\Context\Context;
use BDP\Telegram\Command\Context\StageID;
use BDP\Telegram\Update\Update;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Throwable;

abstract class Pipeline implements Executable
{
    /**
     * @var array Pipeline stages.
     *
     * Note: The order of stages is important. This array defines the sequence of commands in the pipeline.
     */
    protected array $stages = [];

    public function __construct(
        private readonly Update $update,
        private readonly Context $context,
        private readonly ContainerInterface $container
    ) {
    }

    final protected function fetchBy(StageID $ID): StageInterface
    {
        if (array_key_exists($ID->getValue(), $this->stages)) {
            $class = $this->stages[$ID->getValue()];
            try {
                /** @var StageInterface $stage */
                $stage = $this->container->get($class);
                $stage->setContext($this->update);
            } catch (ContainerExceptionInterface $e) {
                throw new StageNotExecutable(previous: $e);
            }
            return $stage;
        }
        throw new StageNotExecutable();
    }

    public function execute(): void
    {
        $stageID = $this->context->getStageID();
        $stage = $this->fetchBy($stageID);
        try {
            $response = $stage->run();
        } catch (Throwable) {
            $response = StageResponse::Abort;
        }
        $this->handleResponse($response, $stage);
        $this->context->getExecutedAt()->setCurrent();
    }

    protected function handleResponse(StageResponse $response, StageInterface $stage): void
    {
        match ($response) {
            StageResponse::Success => $this->handleSuccessResponse($stage),
            StageResponse::Failed => $this->handleFailedResponse($stage),
            StageResponse::Rollback => $this->handleRollbackResponse($stage),
            StageResponse::Finished => $this->handleFinishedResponse($stage),
            StageResponse::Abort => $this->handleAbortResponse($stage),
        };
    }

    private function handleSuccessResponse(StageInterface $stage): void
    {
        $stage->success();
        $this->context->getStageID()->next();
        $this->context->keep();
    }

    private function handleFailedResponse(StageInterface $stage): void
    {
        $stage->failed();
        $this->context->ignore();
    }

    private function handleFinishedResponse(StageInterface $stage): void
    {
        $stage->finish();
        $this->context->remove();
    }

    private function handleRollbackResponse(StageInterface $stage): void
    {
        $stage->rollback();
        $this->context->getStageID()->previous();
        $this->context->keep();
    }

    private function handleAbortResponse(StageInterface $stage): void
    {
        $stage->abort();
        $this->context->remove();
    }
}