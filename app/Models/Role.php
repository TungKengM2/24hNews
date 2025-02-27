<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class Role extends Model
{
    use HasFactory;
    protected $primaryKey = 'role_id'; // Định danh khóa chính
    protected $fillable = ['name', 'description'];
    

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}
