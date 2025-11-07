<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = true;  
    const UPDATED_AT = null;

    protected $guarded = [];

    protected $casts = [
        'payload' => 'array',   // JSONを配列に
        'read_at' => 'datetime',
        'notified_at' => 'datetime',
        'created_at' => 'datetime',
        'action_type' => \App\Enums\NotificationActionType::class,
    ];

    //リレーション--------------------------------------------------------------
    //アクションを受け取った人
    public function recipient()
    {
        return $this->belongsTo(User::class, 'recipient_user_id');
    }

    // アクションを起こした人
    public function actor()
    {
        return $this->belongsTo(User::class, 'actor_user_id');
    }

    public function target()
    {
        return $this->morphTo(null, 'target_type', 'target_id');
    }


    //スコープ関数------------------------------------------------------------
    // 未読
    public function scopeUnread($query)
    {
        return $query->whereNull('read_at');
    }

    // 直近日数分取得
    public function scopeRecentDays($query, $days = 30)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    //ヘルパーメゾット--------------------------------------------------------

    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    public static function unreadCountForUser($userId)
    {
        return static::where('recipient_user_id', $userId)
            ->whereNull('read_at')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();
    }
}
