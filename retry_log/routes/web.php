<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimelineController;
use App\Http\Controllers\ChallengeController;
use App\Http\Controllers\ChallengeLogController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return \Illuminate\Support\Facades\Auth::check()
    ? redirect('/timeline')
    : redirect('/login');
});
Route::get('/login', function (){
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // タイムライン(ホーム画面)
    Route::get('/timeline', [TimelineController::class, 'index'])->name('timeline');
    Route::get('/timeline/{contentType}', [TimelineController::class, 'fetchTimeline'])->name('timeline.fetch');
    //チャレンジ画面
    Route::get('/challenges', [ChallengeController::class, 'index'])->name('challenges');
    Route::get('/challenge-all', [ChallengeController::class, 'all'])->name('challenge-all');
    Route::post('/challenges/store', [ChallengeController::class, 'store'])->name('challenges.store');
    Route::post('/challenges/{challenge}/restart', [ChallengeController::class, 'restart'])->name('challenges.restart');
    Route::delete('/challenges/{challenge}/destroy', [ChallengeController::class, 'destroy'])->name('challenges.destroy');
    //チャレンジログメソッド
    Route::post('/challenge_logs/store', [ChallengeLogController::class, 'store'])->name('challenge_logs.store');
    //チャレンジ進捗
    Route::get('/{user}/progress', [ChallengeController::class, 'progress'])->name('progress');
    // ユーザー系
    Route::get('/{user}/mypage', [UserController::class, 'index'])->name('mypage');
    //フォロー・アンフォロー
    Route::post('/users/{user}/follow', [FollowController::class, 'store'])->name('follow');
    Route::delete('/users/{user}/unfollow', [FollowController::class, 'destroy'])->name('unfollow');
    //ポスト
    Route::get('/{post}/post-show',[PostController::class,'index'])->name('post.show');
    Route::post('/post/store',[PostController::class, 'store'])->name('post.store');
    //リアクション
    Route::post('post/reaction/toggle',[PostController::class,'toggleReaction'])->name('posts.reaction.toggle');
    Route::post('comment/reaction/toggle',[CommentController::class,'toggleReaction'])->name('comments.reaction.toggle');
    //コメント
    Route::post('/comment/store',[CommentController::class, 'store'])->name('comment.store');
    Route::get('/{comment}/comment-show',[CommentController::class,'index'])->name('comment.show');
});

require __DIR__.'/auth.php';
Route::get('/post-create', function () {
    return view('post-create');
})->name('post-create');
