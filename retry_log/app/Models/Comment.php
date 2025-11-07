<?php

namespace App\Models;

use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_type',
        'target_id',
        'parent_id',
        'content',
        'content_type_id',
    ];


    protected static function booted()
    {
        static::creating(function ($comment) {
            if (Auth::check()) {
                $comment->user_id = auth()->id();
            }
        });
        static::created(function ($comment) {
            // $comment が作成されたとき
            $comment->post()->increment('comments_count');
        });

        static::deleted(function ($comment) {
            // $comment が削除されたとき
            $comment->post()->decrement('comments_count');
        });
    }

    public function user() //コメントを書いた人用
    {
        return $this->belongsTo(User::class);
    }
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
    //リアクションの一覧画面
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'target');
    }
    //リアクションの合計数のリアクション
    public function reactionCounts()
    {
        return $this->morphMany(ReactionCount::class, 'target');
    }
    public function target()
    {
        return $this->morphTo();
    }
    public function parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
    public function contentType()
    {
        return $this->belongsTo(ContentType::class, 'content_type_id');
    }
    public function getAvailableReactionsAttribute() //関数めいはavailable_reactions
    {
        return $this->contentType?->reactionTypes ?? collect();
    }
}
