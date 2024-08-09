<?php

declare(strict_types=1);

namespace BDP\Telegram\Command\Structure;

enum StageResponse: int
{
    /**
     * The business logic was successful. Proceed to the next step.
     */
    case Success = 1;

    /**
     * The business logic failed. Stay on the current step (e.g., validation failed).
     */
    case Failed = 2;

    /**
     * Something went wrong. Move back to the previous step.
     */
    case Rollback = 3;

    /**
     * The business logic is completed. Must be used if it's the last stage.
     * If it's the last stage and marked as Success, an error should be thrown.
     */
    case Finished = 4;

    /**
     * Complete cancellation of the command.
     */
    case Abort = 5;
}