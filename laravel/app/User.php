<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Role;

class User extends Authenticatable
{
    use Notifiable;
    
    protected $fillable = [
        'name', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    
    // Relationship:
    // Posts
    public function posts(){
        return $this->hasMany('App\Post');
    }
    
    // Role
    public function role(){
        return $this->hasOne('App\Role');
    }

    // Functions:
    // Name role user
    public function nameRole(){
        $this->role()->first() ? $role = $this->role()->first()->name : $role = null;
        return $role;
    }
}
