<?php

namespace App\Http\Controllers;

use App\Services\UserService;
use App\Services\PostService;
use App\Services\ReactionService;
use App\Services\ChallengeProgressService;
use Illuminate\Http\Request;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $userService;
    protected $postService;
    protected $reactionService;
    protected $challengeProgressService;
    public function __construct(PostService $postService, UserService $userService, ReactionService $reactionService, ChallengeProgressService $challengeProgressService)
    {
        $this->userService = $userService;
        $this->postService = $postService;
        $this->reactionService = $reactionService;
        $this->challengeProgressService = $challengeProgressService;
    }
    public function index()
    {
        //profile-card用の処理
        $currentUser = auth()->user();
        $profileUserId = $currentUser->id; //userとプロフィールuserは同じにする
        $profileUser = $this->userService->getUserProfile($profileUserId);
        $context = $this->userService->getProfileContext($currentUser, $profileUser);
        $retryRate = round($this->challengeProgressService->getRetryRate($profileUserId)->get('retry_rate')*100);
        //timeline用の処理
        $timeline = $this->postService->getTimelinePosts('success',20);
        return view('timeline', ['profileUser'=>$profileUser, 'isOwnProfile' => $context['isOwnProfile'], 'isFollowing' => $context['isFollowing'],'retryRate' => $retryRate, 'timeline'=>$timeline]);
    }
    public function fetchTimeline(string $contentType)
{
        $posts = $this->postService->getTimelinePosts($contentType, 20);
        $currentUser = auth()->user();
        $profileUserId = $currentUser->id; //userとプロフィールuserは同じにする
        $profileUser = $this->userService->getUserProfile($profileUserId);
        $context = $this->userService->getProfileContext($currentUser, $profileUser);
        $retryRate = round($this->challengeProgressService->getRetryRate($profileUserId)->get('retry_rate')*100);
        //timeline用の処理
        $timeline = $this->postService->getTimelinePosts($contentType,20);
        return view('partials.timeline-posts', ['profileUser'=>$profileUser, 'isOwnProfile' => $context['isOwnProfile'], 'isFollowing' => $context['isFollowing'],'retryRate' => $retryRate, 'timeline'=>$timeline])->render();
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
        //
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
