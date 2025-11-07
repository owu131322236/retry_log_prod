<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        //新しく追加したフィールド
        'icon',
        'bio',
    ];
    
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'points' =>'integer',
        ];
    }

    public function challenges()
    {
        return $this->hasMany(Challenge::class);
    }
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function reactions()
    {
        return $this->hasMany(Reaction::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'recipient_user_id');
    }

    public function followings() //followしている人
    {
        return $this->belongsToMany(
            User::class,
            'follows',   //中間テーブル名   
            'follower_id',  // このUserのIDが入るカラム
            'followee_id'   // 相手のUserのIDが入るカラム
        );
    }

    public function followers()//followされている人
    {
        return $this->belongsToMany(
            User::class,
            'follows',
            'followee_id',  // このUserのIDが入るカラム
            'follower_id'  // 相手のUserのIDが入るカラム
        );
    }
    public function follow(User $user)
    {
        if ($this->id !== $user->id && !$this->isFollowing($user)) {
            $this->followings()->attach($user->id);
        }
    }
    public function unfollow(User $user)
    {
        $this->followings()->detach($user->id);
    }
    public function isFollowing(User $user): bool
    {
        return $this->followings()->where('followee_id', $user->id)->exists();
    }
    public function icon()
{
    return $this->belongsTo(Image::class, 'icon_id');
}

public function background()
{
    return $this->belongsTo(Image::class, 'background_id');
}
}
