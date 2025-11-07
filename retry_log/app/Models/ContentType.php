<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentType extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function reactionTypes()
    {
        return $this->hasMany(ReactionType::class);
    }
}
