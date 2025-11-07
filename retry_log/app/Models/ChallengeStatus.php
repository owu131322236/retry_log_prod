<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChallengeStatus extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $guarded = [];
    public function challengeLogs()
    {
        return $this->hasMany(ChallengeLog::class, 'status_id');
    }
}
