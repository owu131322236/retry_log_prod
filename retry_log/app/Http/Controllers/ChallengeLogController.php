<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\ChallengeLog;
use App\Models\ChallengeStatus;
use App\Services\ChallengeService;
use Illuminate\Http\Request;

class ChallengeLogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $challengeLog;
    protected $challengeService;
    public function __construct(ChallengeLog $challengeLog, ChallengeService $challengeService)
    {
        $this->challengeLog = $challengeLog;
        $this->challengeService = $challengeService;
    }
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Challenge $challenge, ChallengeService $challengeService)
    {
        $validated = $request->validate([
            'challenge_id' => 'required|exists:challenges,id',
            'status' => 'required|exists:challenge_statuses,name',
            'logged_at' => 'nullable|date',
        ]);
        $userId = auth()->id();
        $challenge = Challenge::where('id', $validated['challenge_id'])
            ->where('user_id', $userId)
            ->firstOrFail();

        $status = ChallengeStatus::where('name', $request->status)->firstOrFail();
        $achievmentRate = $challengeService->calculateAcheivementRate($challenge);

        $alreadyLogged = ChallengeLog::where('challenge_id', $challenge->id)
            ->whereDate('logged_at', now())
            ->exists();
        if ($alreadyLogged) {
            return response()->json([
                'message' => '本日はすでに記録されています。',
            ], 409);
        }
        $challengeLog = ChallengeLog::create([
            'challenge_id' => $validated['challenge_id'],
            'status_id' => $status->id,
            'logged_at' => $validated['logged_at'] ?? now(),
        ]);
        $challengeLog->save();

        // チャレンジの保存
        $rate = $challengeService->calculateAcheivementRate($challenge);

        $challenge->achievement_rate = round($rate * 100, 2);
        $challenge->save();

        return redirect()->route('challenges')->with('success', 'チャレンジログが記録されました。');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
