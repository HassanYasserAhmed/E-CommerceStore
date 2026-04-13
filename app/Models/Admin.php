<?php

namespace App\Models;

use App\Concertns\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Admin extends User
{
    use HasFactory,
        Notifiable,
        HasApiTokens,
        HasRoles;
    protected $fillable = [
        'name','email','phone_number','password','super_admin','status'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
}

