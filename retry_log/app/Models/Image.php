<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function iconUsers()
    {
        return $this->hasMany(User::class, 'icon_id');
    }
    public function backgroundUsers()
    {
        return $this->hasMany(User::class, 'background_id');
    }
}
