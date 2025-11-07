<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Challenge;
use App\Services\ChallengeService;
use Carbon\Carbon;

class UpdateOngoingChallengesAchievement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'challenges:update-achievement';
    protected $challengeService;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(ChallengeService $challengeService)
    {
        parent::__construct();
        $this->challengeService = $challengeService;
    }
    public function handle()
    {
        $today = Carbon::today();
        $challenges = Challenge::whereIn('state', ['in_progress', 'not_started'])->get();

        foreach ($challenges as $challenge) {
            $rate = $this->challengeService->calculateAcheivementRate($challenge);
            $challenge->achievement_rate = round($rate * 100, 2);
            $challenge->save();
        }

        $this->info('Achievement rates updated for ongoing challenges.');
    }
}
