<?php

namespace App\Enums;

enum ChallengeState: string
{
    case NOT_STARTED = 'not_started';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
    case INTERRUPTED = 'interrupted';
    case FAILED = 'failed';
}