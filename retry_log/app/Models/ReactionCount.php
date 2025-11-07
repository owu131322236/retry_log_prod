<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionCount extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $primaryKey = null;
    protected $guarded = [];

    protected $casts = [
        'count' => 'integer',
        'target_id' => 'integer'
    ];

    public function reactionType()
    {
        return $this->belongsTo(ReactionType::class);
    }
}
