<?php

namespace App\Http\Controllers;
use App\Models\Challenge;
use App\Models\User;
use App\Services\ChallengeService;
use App\Services\ChallengeProgressService;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $challengeService;
    protected $challengeProgressService;
    public function __construct(ChallengeService $challengeService, ChallengeProgressService $challengeProgressService)
    {
        $this->challengeService = $challengeService;
        $this->challengeProgressService = $challengeProgressService;
    }
    public function index()
    {
        $ongoingChallenges = $this->challengeService->getUserOngoingChallenges(auth()->id(), 20, true);
        $endedChallenges = $this->challengeService->getUserEndedChallenges(auth()->id(), 20, true);
        return view('challenges.index', compact('ongoingChallenges', 'endedChallenges'));
    }
    public function all()
    {
        $endedChallenges = $this->challengeService->getUserEndedChallenges(auth()->user()->id, 20, true);
        return view('challenges.all', compact('endedChallenges'));
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
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:15',
            'description' => 'nullable|string|max:200',
            'frequency_type' => 'required|in:daily,weekly,monthly',
            'frequency_goal' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            //ここpush前に直す
        ]);
        $challenge = Challenge::create([
            'user_id' => auth()->id(),
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'frequency_type' => $validated['frequency_type'],
            'frequency_goal' => $validated['frequency_goal'],
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
        ]);
        $challenge->state = $this->challengeService->calculateChallengeState($challenge);
        $challenge->current_streak = 0;
        $challenge->max_streak = 0;
        $challenge->save();
        return redirect()->route('challenges')->with('success', 'チャレンジが作成されました');
    }
    public function restart(Request $request, Challenge $challenge)
    {   
        $validated = $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);
        $original = $challenge;
        if($original->user_id !== auth()->id()){
            abort(403,'あなたはこの操作を実行する権限がありません');
        }
        $newChallenge = $original->replicate(['start_date', 'end_date', 'state','created_at','updated_at']); //これらのカラムは複製しない
        $newChallenge->start_date = $validated['start_date'];
        $newChallenge->end_date = $validated['end_date'];
        $newChallenge->state = $this->challengeService->calculateChallengeState($newChallenge);
        $newChallenge->save();
        return redirect()
            ->route('challenges')
            ->with('success', 'チャレンジが再開されました');
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
        $challenge = Challenge::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:15',
            'description' => 'nullable|string',
            'frequency_type' => 'required|in:daily,weekly,monthly',
            'frequency_goal' => 'required|integer|min:1',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $challenge->update($validated);
        $challenge->state = $this->challengeService->calculateChallengeState($challenge);
        $challenge->save();
        return redirect()
            ->route('challenges')
            ->with('success', 'チャレンジが更新されました');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Challenge $challenge)
    {
        if($challenge->user_id !== auth()->id()){
            abort(403,'あなたはこの操作を実行する権限がありません');
        }
        $challenge->delete();
        return redirect()
            ->route('challenges')
            ->with('success', 'チャレンジが削除されました');
    }
    public function progress(User $user)
    {
        $userId = $user->id;
        $progressData = [];
        $modes = ['1w', '1m', '6m', '1y'];
        foreach($modes as $mode){
            //統計データを取得
            $data = $this->challengeProgressService->calculateProgress($userId, $mode);
            $progressData[$mode] = $data;
            //表示用データ
            $challengesCounts[$mode] = $data['challenges']->count();
            $completedChallengesCounts[$mode] = $data['challenges']->filter(function($challenge){
                return $challenge->state === 'completed';
            })->count();
            //詳細データを取得
            $detailDates = $this->challengeProgressService->calculateProgressDetail($userId, $mode);
            $progressDetailData[$mode] = $detailDates;
            
        }
        $ongoingChallenges = $this->challengeService->getUserOngoingChallenges(auth()->id(), 20, true);
        $endedChallenges = $this->challengeService->getUserEndedChallenges(auth()->id(), 20, true);
        return view('progress', compact('user','progressData','challengesCounts','completedChallengesCounts','progressDetailData','modes','ongoingChallenges','endedChallenges'));
    }
    
}
