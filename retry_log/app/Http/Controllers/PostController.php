<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ContentType;
use App\Services\PostService;
use App\Services\ReactionService;
use App\Services\UserService;
use App\Services\ChallengeProgressService;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userService;
    protected $postService;
    protected $reactionService;
    protected $challengeProgressService;

    public function __construct(UserService $userService, PostService $postService, ReactionService $reactionService, ChallengeProgressService $challengeProgressService)
    {
        $this->userService = $userService;
        $this->postService = $postService;
        $this->reactionService = $reactionService;
        $this->challengeProgressService = $challengeProgressService;
    }
    public function index(Post $post)
    {
        //PostとComment共通ページなので注意！
        //profile-card用の処理
        $currentUser = auth()->user();
        $profileUserId = $post->user_id;
        $profileUser = $this->userService->getUserProfile($profileUserId);
        $context = $this->userService->getProfileContext($currentUser, $profileUser);
        $retryRate = round($this->challengeProgressService->getRetryRate($profileUserId)->get('retry_rate') * 100);
        //post用の処理
        $post = $this->postService->getPostDetail($post->id);
        return view('post-show', ['target' => $post, 'profileUser' => $profileUser, 'isOwnProfile' => $context['isOwnProfile'], 'isFollowing' => $context['isFollowing'],'retryRate' => $retryRate]);
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
            'content' => 'required|string|max:200',
            'content_type' => 'required|string|exists:content_types,name',
        ]);
        $content_type = ContentType::where('name', $request->content_type)->firstOrFail();
        $post = Post::create([
            'user_id' => auth()->id(),
            'content' => $validated['content'],
            'content_type_id' => $content_type->id,
        ]);
        $post->save();
        return redirect()->back()->with('success', 'ポストが投稿されました');
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
