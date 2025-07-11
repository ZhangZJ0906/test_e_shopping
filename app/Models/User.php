<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',  // 🔥 加這行
    ];
    // 🔥 角色常數定義
    const ROLE_ADMIN = 'admin';
    const ROLE_BOSS = 'boss';
    const ROLE_ENGINEER = 'engineer';
    const ROLE_GUEST = 'guest';
    const ROLE_MEMBER = 'member';

    // 🔥 角色判斷方法
    public function isAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function isBoss()
    {
        return $this->role === self::ROLE_BOSS;
    }

    public function isEngineer()
    {
        return $this->role === self::ROLE_ENGINEER;
    }
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
