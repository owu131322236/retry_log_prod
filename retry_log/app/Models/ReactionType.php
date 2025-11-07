<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReactionType extends Model
{
    use HasFactory;

    protected $casts = [
        'is_active' => 'boolean',
        'is_special' => 'boolean',
        'point_cost' => 'integer',
    ];
    public $timestamps = false;
    public function contentType()
    {
        return $this->belongsTo(ContentType::class);
    }
    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }
// スコープ関数---------------------------------------------------------------
    public function scopeCommon($query)
    {
        return $query->whereNull('content_type_id');
    }

    public function scopeForContentType($query, $contentTypeId)
    {
        return $query->where('content_type_id', $contentTypeId);
    }
}
