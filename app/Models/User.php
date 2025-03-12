<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Authenticatable implements CanResetPasswordContract
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword, HasDatabaseNotifications;

    protected $primaryKey = 'user_id'; // Định danh khóa chính

    protected $fillable = [
        'username',
        'email',
        'password',
        'phone',
        'image',
        'role_id',
        'is_promoted',
        'violation_count',
        'banned_until',
        'provider',
        'provider_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'banned_until' => 'datetime',
    ];

    /**
     * Quan hệ với bảng roles
     */
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function approvals()
    {
        return $this->hasMany(Approval::class, 'user_id');
    }

    public function savedArticles()
    {
        return $this->hasMany(ArticleSave::class, 'user_id', 'user_id');
    }
}
