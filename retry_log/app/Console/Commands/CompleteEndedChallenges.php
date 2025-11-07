<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Challenge;
use Carbon\Carbon;
use App\Models\ChallengeLog;
use App\Services\ChallengeService;

class CompleteEndedChallenges extends Command
{
    protected $signature = 'challenges:finalize';
    protected ChallengeService $challengeService;

    public function __construct(ChallengeService $challengeService)
    {
        parent::__construct();
        $this->challengeService = $challengeService;
    }

    public function handle()
    {
        $today = Carbon::today()->endOfDay();

        $challenges = Challenge::whereNotNull('end_date')
            ->where('end_date', '<', $today)
            ->whereIn('state', ['in_progress', 'not_started'])
            ->get();
        foreach ($challenges as $challenge) {
            $state = $this->challengeService->calculateChallengeState($challenge);
            $challenge->state = $state->value;
            $rate = $this->challengeService->calculateAcheivementRate($challenge);
            $challenge->achievement_rate = round($rate * 100, 2);
            $challenge->save();
        }

        $this->info('Challenges finalized.');
    }
}