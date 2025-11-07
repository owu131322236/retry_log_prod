<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChallengeLog extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'logged_at' => 'datetime',
    ];

    public function challenge()
    {
        return $this->belongsTo(Challenge::class,'challenge_id');
    }
    public function challengeStatus()
    {
        return $this->belongsTo(ChallengeStatus::class,'status_id');
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}
