<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Structure;

interface StageInterface
{
    /**
     * Execute the stage and return the response.
     *
     * @return StageResponse The result of the stage execution.
     */
    public function run(): StageResponse;

    /**
     * Mark the stage as successful. Called if the stage execution was successful.
     *
     * @return void
     */
    public function success(): void;

    /**
     * Mark the stage as failed. Called if the stage execution failed.
     *
     * @return void
     */
    public function failed(): void;

    /**
     * Mark the stage as finished. Called when the stage completes its business logic.
     *
     * @return void
     */
    public function finish(): void;

    /**
     * Roll back the stage. Called if the stage needs to revert its changes.
     *
     * @return void
     */
    public function rollback(): void;

    /**
     * Abort the stage. Called if the stage execution needs to be aborted.
     *
     * @return void
     */
    public function abort(): void;
}