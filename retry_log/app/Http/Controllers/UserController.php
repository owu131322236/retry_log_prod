<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\UserService;
use App\Services\PostService;
use App\Services\ChallengeService;
use App\Services\ChallengeProgressService;
use Illuminate\Container\Attributes\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected UserService $userService;
    protected PostService $postService;
    protected ChallengeService $challengeService;
    protected ChallengeProgressService $challengeProgressService;
    public function __construct(UserService $userService, PostService $postService, ChallengeService $challengeService, ChallengeProgressService $challengeProgressService)
    {
        $this->userService = $userService;
        $this->postService = $postService;
        $this->challengeService = $challengeService;
        $this->challengeProgressService = $challengeProgressService;
    }
    public function index(User $user)
    {   //profile-card用の処理
        $currentUser = auth()->user();
        $profileUserId = $user->id;
        $profileUser = $this->userService->getUserProfile($profileUserId);
        $context = $this->userService->getProfileContext($currentUser, $profileUser);
        $retryRate = round($this->challengeProgressService->getRetryRate($profileUserId)->get('retry_rate')*100);
        //mypage用の処理
        $posts = $this->postService->getUserPosts($profileUserId, 20);
        $reactionPosts = $this->postService->getReactionPosts($profileUserId, 20);
        $challenges = $this->challengeService->getUserOngoingChallenges($profileUserId, 20, false);
        return view('mypage', [
            'profileUser' => $profileUser,
            'currentUser' => $currentUser,
            'posts' => $posts,
            'reactionPosts' => $reactionPosts,
            'challenges' => $challenges,
            'isOwnProfile' => $context['isOwnProfile'],
            'isFollowing' => $context['isFollowing'],
            'retryRate' => $retryRate,
        ]);
    }
}
