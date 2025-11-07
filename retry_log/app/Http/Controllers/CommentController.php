<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Services\UserService;
use App\Services\ReactionService;
use App\Services\ChallengeProgressService;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    protected $userService;
    protected $challengeProgressService;
    protected $reactionService;

    public function __construct(UserService $userService, ChallengeProgressService $challengeProgressService, ReactionService $reactionService)
    {
        $this->userService = $userService;
        $this->challengeProgressService = $challengeProgressService;
        $this->reactionService = $reactionService;
    }
    public function index(Comment $comment)
    {
        //PostとComment共通ページなので注意！
        //profile-card用の処理
        $currentUser = auth()->user();
        $profileUserId = $comment->user_id;
        $profileUser = $this->userService->getUserProfile($profileUserId);
        $context = $this->userService->getProfileContext($currentUser, $profileUser);
        $retryRate = round($this->challengeProgressService->getRetryRate($profileUserId)->get('retry_rate') * 100);
        // コメント用の処理はなし
        return view('post-show', ['target' => $comment, 'profileUser' => $profileUser, 'isOwnProfile' => $context['isOwnProfile'], 'isFollowing' => $context['isFollowing'],'retryRate' => $retryRate]);
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
        $parentId = null;
        if ($request->target_type === Comment::class) {
            $parentId = $request->target_id;
        }
        $request->validate([
            'target_type' => ['required'],
            'target_id' => ['required'],
            'content' => ['required', 'string', 'max:300'],
        ]);
        Comment::create([
            'user_id' => auth()->user()->id,
            'target_type' =>$request->target_type,
            'target_id' =>$request->target_id,
            'parent_id' =>$parentId,
            'content' =>$request->content,
        ]);
        return redirect()->back()->with('success', '返信を投稿しました！');
    }
    public function toggleReaction(Request $request, ReactionService $reactionService)
    {
        $validated = $request->validate([
            'target_type' => 'required|string',
            'target_id' => 'required|integer',
            'reaction_type_id' => 'required|integer|exists:reaction_types,id',
        ]);
        $reactionService->toggleReaction(
            $validated['target_type'],
            $validated['target_id'],
            $validated['reaction_type_id']
        );

        return back();
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
