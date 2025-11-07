<?php

namespace App\Services;

use App\Enums\ChallengeState;
use App\Models\ChallengeLog;
use App\Models\Challenge;
use Carbon\Carbon;

class ChallengeService
{
    public function getUserChallenges($userId)
    {
        return Challenge::with(['challengeLogs', 'challengeLogs.challengeStatus'])
            ->where('user_id', $userId)
            ->latest();
    }
    public function getUserOngoingChallenges(int $userId, int $limit = 20, $usePaginate = false)
    {
        $query = $this->getUserChallenges($userId)
            ->whereIn('state', ['not_started', 'in_progress'])
            ->withCount(['challengeLogs as is_recorded_today' => function ($q) {
                $q->whereDate('logged_at', Carbon::today());
            }])
            ->orderBy('is_recorded_today', 'asc') //昇順
            ->distinct();
        return $usePaginate
            ? $query->take($limit)->cursorPaginate($limit)
            : $query->take($limit)->get();
    }
    public function getChallengesContext(Challenge $challenge)
    {
        $isRecoredToday = $challenge->challengeLogs()
            ->whereDate('logged_at', Carbon::today())
            ->exists();
        return [
            'isRecoredToday' => $isRecoredToday,
        ];
    }
    public function getUserEndedChallenges(int $userId, int $limit = 20, $usePaginate = false)
    {
        $query = $this->getUserChallenges($userId)
            ->whereIn('state', ['failed', 'interrupted', 'completed']);
        return $usePaginate
            ? $query->cursorPaginate($limit)
            : $query->take($limit)->get();
    }


    //Challengeの達成率を計算するメソッド
    public function calculateAcheivementRate(Challenge $challenge)
    {
        $today = Carbon::today();
        $start = $challenge->start_date;
        $logs = ChallengeLog::with('challengeStatus')
            ->where('challenge_id', $challenge->id)
            ->whereBetween('logged_at', [$start, $today])
            ->get();
        $expectedTotal = match ($challenge->frequency_type->value) {
            'daily' => $start->diffInDays($today) + 1,
            'weekly' => ceil(($start->diffInDays($today) + 1) / 7),
            'monthly' => ceil(($start->diffInDays($today) + 1) / 30),
            default => 0,
        };
        $expectedTotal *= ($challenge->frequency_goal ?? 1);
        $successCount = $logs->filter(function ($log) {
            return $log->challengeStatus->name === 'success';
        })->count();
        $achievementRate = $expectedTotal > 0 ? $successCount / $expectedTotal : 0;
        return $achievementRate;
    }
    public function calculateChallengeState(Challenge $challenge)
    {
        $now = Carbon::now();
        if ($challenge->start_date && $challenge->start_date->isFuture()) {
            return ChallengeState::NOT_STARTED;
        }
        if (is_null($challenge->end_date)) {
            return ChallengeState::IN_PROGRESS;
        }
        if ($challenge->state === ChallengeState::INTERRUPTED) {
            return ChallengeState::INTERRUPTED;
        }
        if ($challenge->end_date->lt($now)) {
            $rate = $this->calculateAcheivementRate($challenge);
            return $rate >= 0.7
                ? ChallengeState::COMPLETED
                : ChallengeState::FAILED;
        }
        return ChallengeState::IN_PROGRESS;
    }
    public function updateChallengeStreak(Challenge $challenge)
    {
        $logs = $challenge->challengeLogs()
            ->whereHas('challengeStatus', fn($q) => $q->where('name', 'success'))
            ->orderBy('logged_at')
            ->get();

        $current = 0;
        $max = 0;
        $previousDay = null;

        foreach ($logs as $log) {
            $day = $log->logged_at->startOfDay();
            if ($previousDay && $day->equalTo($previousDay)) {
                continue;
            }

            if ($previousDay && $day->diffInDays($previousDay) === 1) {
                $current++;
            } else {
                $current = 1;
            }

            $max = max($max, $current);
            $previousDay = $day;
        }

        $challenge->max_streak = $max;
        $challenge->save();
    }
}
