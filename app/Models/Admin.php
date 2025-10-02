<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Admin extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'username', 
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function gifts()
    {
        return $this->hasMany(Gift::class, 'admin_id');
    }
}
