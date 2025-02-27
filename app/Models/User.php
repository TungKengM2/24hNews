<?php

    namespace App\Models;

    // use Illuminate\Contracts\Auth\MustVerifyEmail;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Foundation\Auth\User as Authenticatable;
    use Illuminate\Notifications\Notifiable;
    use Laravel\Sanctum\HasApiTokens;
    use Illuminate\Auth\Passwords\CanResetPassword;
    use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

    class User extends Authenticatable implements CanResetPasswordContract
    {

        use HasApiTokens, HasFactory, Notifiable, CanResetPassword;

        /**
         * The attributes that are mass assignable.
         *
         * @var array<int, string>
         */
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
        ];

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

    }
