<?php

namespace App\Services;

use App\Enums\ChallengeFrequency;
use App\Models\Challenge;
use App\Models\ChallengeLog;
use Carbon\Carbon;

class ChallengeProgressService
{
    public function calculateProgress($userId, $mode = '1w')
    {
        $today = Carbon::today()->endOfDay();
        $periods = $this->splitPeriod($today, $mode);
        $start = $periods->first()['start'];
        $end   = $periods->last()['end'];
        $challenges = Challenge::where('user_id', $userId)
            ->where(function ($q) use ($start, $end) {
                $q->where('start_date', '<=', $end)
                    ->where(function ($q2) use ($start) {
                        $q2->whereNull('end_date')
                            ->orWhere('end_date', '>=', $start);
                    });
            })
            ->get();
        $logs = ChallengeLog::with('challengeStatus')
            ->whereIn('challenge_id', $challenges->pluck('id')) //pluckでidだけの配列を取得
            ->whereBetween('logged_at', [$start, $end])
            ->get();
        $expectedTotal = $challenges->sum(function ($challenge) use ($start, $end) {
            $goal = $challenge->frequency_goal ?? 1;
            $type = $challenge->frequency_type->value;
            $days = $start->copy()->diffInDays($end) + 1;
            return match ($type) {
                'daily' => (float)($days * $goal),
                'weekly' => (float)(($days / 7) * $goal),
                'monthly' => (float)(($days / 30) * $goal),
                default => 0.0,
            };
        });
        $successCount = $logs->filter(function ($log) {
            return $log->challengeStatus?->name === 'success';
        })->count();
        $achievementRate = $expectedTotal > 0 ? $successCount / $expectedTotal : 0;
        // dump($logs, $successCount);
        // $groupKey = match($mode){
        //     '1w' => 'Y-m-d',
        //     '1m' => 'Y-m-W', 
        //     '6m' => 'Y-m-w',
        //     '1y' => 'Y-m',
        //     default => 'Y-m-d',
        // };

        return collect([
            'mode' => $mode,
            'start' => $start->toDateString(),
            'end' => $today->toDateString(),
            'logs' => $logs,
            'expected_total' => $expectedTotal,
            'success_total' => $successCount,
            'challenges' => $challenges,
            'achievement_rate' => round($achievementRate * 100, 2),
        ]);
    }
    public function calculateProgressDetail($userId, $mode = '1w')
    {
        $today = Carbon::today()->endOfDay();
        $end = $today;
        $dataDetail = collect();
        $periods = $this->splitPeriod($end, $mode);
        $entireStart =  $periods->first()['start'];
        $entireEnd =  $periods->last()['end'];

        foreach ($periods as $period) {
            $start = $period['start']->copy()->startOfDay();
            $end = $period['end']->copy()->endOfDay();
            $challenges = Challenge::where('user_id', $userId)
                ->where(function ($q) use ($entireStart, $entireEnd) {
                    $q->where('start_date', '<=', $entireEnd)
                        ->where(function ($q2) use ($entireStart) {
                            $q2->whereNull('end_date')
                                ->orWhere('end_date', '>=', $entireStart);
                        });
                })
                ->get();
            $logs = ChallengeLog::with('challengeStatus')
                ->whereIn('challenge_id', $challenges->pluck('id'))
                ->whereBetween('logged_at', [$start, $end])
                ->get();
            $successCount = $logs->filter(function ($log): bool {
                return $log->challengeStatus?->name === 'success';
            })->count();
            $expectedTotal = $challenges->sum(function ($ch) use ($start, $end) {
                $goal = $ch->frequency_goal ?? 1;
                $type = $ch->frequency_type->value;
                $days = $start->diffInDays($end) + 1; //合計日数
                return match ($type) {
                    'daily' => $days * $goal,
                    'weekly' => ceil($days / 7) * $goal,
                    'monthly' => ceil($days / 30) * $goal,
                    default => 0,
                };
            });        
            $achievementRate = $expectedTotal > 0
                ? round(($successCount / $expectedTotal) * 100, 2)
                : 0;
            $dataDetail->push([
                'period' => $period,
                'start' => $start,
                'end' => $end,
                'logs' => $logs,
                'success_total' => $successCount,
                'expected_total' => $expectedTotal,
                'achievement_rate' => $achievementRate,
            ]);
        }
        return $dataDetail;
    }
    private function splitPeriod(Carbon $end, $mode)
    {
        $periods = collect();

        switch ($mode) {
            case '1w':
                $currentStart = $end->copy()->startOfWeek(Carbon::SUNDAY);
                while ($currentStart->lte($end)) { //lte = less than or equal
                    $periods->push([
                        'start' => $currentStart->copy()->startOfDay(),
                        'end' => $currentStart->copy()->endOfDay(),
                    ]);
                    $currentStart->addDay(); //+1日する
                }
                break;

            case '1m':
                $currentStart = $end->copy()->startOfMonth()->startOfWeek(Carbon::SUNDAY);
                while ($currentStart->lte($end)) {
                    $periods->push([
                        'start' => $currentStart->copy()->startOfDay(),
                        'end' => $currentStart->copy()->endOfWeek(Carbon::SATURDAY)->endOfDay(),
                    ]);
                    $currentStart->addWeek();
                }
                break;
            case '6m':
                $start = $end->copy()->subMonths(5)->startOfMonth();
                $currentStart = $start->copy();
                while ($periods->count() < 6) {
                    $periods->push([
                        'start' => $currentStart->copy()->startOfDay(),
                        'end' => $currentStart->copy()->endOfMonth()->endOfDay(),
                    ]);
                    $currentStart->addMonth();
                }
                break;
            case '1y':
                $start = $end->copy()->subYear()->addMonth()->startOfMonth();
                $currentStart = $start->copy();
                while ($periods->count() < 12) {
                    $periods->push([
                        'start' => $currentStart->copy()->startOfDay(),
                        'end' => $currentStart->copy()->endOfMonth()->endOfDay(),
                    ]);
                    $currentStart->addMonth();
                }
                break;
        }
        return $periods;
        
    }
    

    public function getRetryRate($userId)
    {
        $logs = ChallengeLog::with(['challengeStatus', 'challenge'])
            ->whereHas('challenge', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->orderByRaw('IFNULL(challenge_logs.logged_at, challenge_logs.created_at) ASC')
            ->get();
        $retryCount = 0;
        $failCount = 0;
        $logs->groupBy('challenge_id')->each(function ($challengeLogs) use (&$retryCount, &$failCount) {
            for ($i = 0; $i < $challengeLogs->count() - 1; $i++) {
                $currentChallengeLog = $challengeLogs->get($i);
                $nextChallengeLog = $challengeLogs->get($i + 1);
                $test = $currentChallengeLog->challengeStatus?->name;
                if (
                    $currentChallengeLog->challengeStatus?->name === 'fail' ||
                    $currentChallengeLog->challengeStatus?->name === 'skipped'
                ) {
                    $failCount++;
                    if ($nextChallengeLog->challengeStatus?->name === 'success') {
                        $retryCount++;
                    }
                }
            }
        });
        $retryRate = $failCount > 0 ? round($retryCount / $failCount, 2) : 0;
        return collect([
            'retry_total' => $retryCount,
            'fail_total' => $failCount,
            'retry_rate' => $retryRate,
        ]);
    }
    public function challengeCountsByState($userId)
    {
        $states = ['not_started', 'in_progress', 'completed', 'interrupted', 'failed'];
        $counts = [];
        $totalChallenges = Challenge::where('user_id', $userId)->count();
        $completedChalenges = Challenge::where('user_id', $userId)
            ->where('state', 'completed')
            ->count();
        $ongoingChallenges = Challenge::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('state', 'not_started')
                    ->orWhere('state', 'in_progress');
            })
            ->count();
        $endedChallenges = Challenge::where('user_id', $userId)
            ->where(function ($query) {
                $query->where('state', 'completed')
                    ->orWhere('state', 'interrupted')
                    ->orWhere('state', 'failed');
            })
            ->count();
        return [
            'total' => $totalChallenges,
            'completed' => $completedChalenges,
            'ongoing' => $ongoingChallenges,
            'ended' => $endedChallenges,
        ];
    }
}
