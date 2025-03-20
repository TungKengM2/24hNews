<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Notifications\HasDatabaseNotifications;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Notifications\DatabaseNotification;

class User extends Authenticatable implements CanResetPasswordContract
{
    use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

    protected $primaryKey = 'user_id'; // Khóa chính
    public $incrementing = true; // Vì user_id là AUTO_INCREMENT
    protected $keyType = 'int'; // Kiểu dữ liệu là số nguyên

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
        'fullname',
        'dob',
        'address'
       
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
    public function comments()
    {
        return $this->hasMany(Comment::class, 'user_id', 'comment_id')->latest();
    }
    public function notifications()
    {
        return $this->morphMany(DatabaseNotification::class, 'notifiable', 'notifiable_type', 'notifiable_id', 'user_id');
    }

}
