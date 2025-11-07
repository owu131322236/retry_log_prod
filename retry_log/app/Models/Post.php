<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'content',
        'content_type_id'
    ];

    protected $casts = [
        'comments_count' => 'integer',
    ];

    protected $attributes = [
        'comments_count' => 0,
    ];

    protected static function booted() //作成時に自動でuser_idをセット
    {
        static::creating(function ($post) {
            if (Auth::check()) {
                $post->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function challengeLog()
    {
        return $this->belongsTo(ChallengeLog::class)->withDefault();
    }
    public function comments()
    {
        return $this->morphMany(Comment::class, 'target');
    }
    public function contentType()
    {
        return $this->belongsTo(ContentType::class, 'content_type_id');
    }
    public function reactions()
    {
        return $this->morphMany(Reaction::class, 'target');
    }

    public function reactionCounts()
    {
        return $this->morphMany(ReactionCount::class, 'target');
    }
    public function userReaction()
    {
        return $this->morphMany(Reaction::class, 'target')
            ->where('user_id', auth()->id());
    }

    public function scopeType($query, int $contentTypeId)
    {
        return $query->where('content_type_id', $contentTypeId);
    }
    public function getAvailableReactionsAttribute() //関数めいはavailable_reactions
    {
        return $this->contentType?->reactionTypes ?? collect();
    }
    public function getCreatedHumanAttribute()
    {
        $date = $this->created_at;
        $days = $date->diffInDays();

        if ($days == 0) {
            return $date->locale('ja')->diffForHumans();
        } elseif ($days < 1) {
            return $date->locale('ja')->diffForHumans();
        } elseif ($days < 365) {
            return $date->locale('ja')->format('m/d');
        }
        return $date->format('Y/m/d');
    }
}
