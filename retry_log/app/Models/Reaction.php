<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Testing\Fluent\Concerns\Has;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class Reaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'target_type',
        'target_id',
        'reaction_type_id',
    ];

    protected static function booted()
    {
        static::creating(function ($reaction) {
            if (Auth::check()) {
                $reaction->user_id = auth()->id();
            }
        });
        static::created(function ($reaction) {
            $countRecord = ReactionCount::updateOrCreate(
                [
                    'target_type' => $reaction->target_type,
                    'target_id' => $reaction->target_id,
                    'reaction_type_id' => $reaction->reaction_type_id,
                ],
                [
                    'count' => 0,
                ],
            );
            $countRecord->increment('count');
        });

        static::deleted(function ($reaction) {
            $countRecord = ReactionCount::where('target_type', $reaction->target_type)
                ->where('target_id', $reaction->target_id)
                ->where('reaction_type_id', $reaction->reaction_type_id)
                ->first();

            if ($countRecord) {
                $countRecord->decrement('count');
                if ($countRecord->count <= 0) {
                    ReactionCount::where('target_type', $reaction->target_type)
                        ->where('target_id', $reaction->target_id)
                        ->where('reaction_type_id', $reaction->reaction_type_id)
                        ->delete();
                }
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function reactionType()
    {
        return $this->belongsTo(ReactionType::class);
    }
    public function target()
    {
        return $this->morphTo(null, 'target_type', 'target_id');
    }
}
