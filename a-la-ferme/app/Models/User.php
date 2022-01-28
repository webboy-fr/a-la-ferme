<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
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
    ];

    /**
     * 
     * A user can have one or many farm
     * 
     */
    public function farms() {
        return $this->hasMany('App\Farm');
    }

    /**
     * 
     * A user can belong to many roles
     * 
     */
    public function roles(){
        return $this->belongsToMany('App\Models\Role');
    }

    /**
     * 
     * Checking if a user has a roles
     * 
     * @param Roles $roles Take a roles in params
     * 
     * @return Bool return false if the user don't have a role
     */
    public function hasAnyRole($roles) {
        return null != $this->roles()->whereIn('name', $roles)->first();
    }

    /**
     * 
     * Checking if a user is in the given role
     * 
     * @param Roles $role Take a role in parameter
     * 
     * @return Bool return true if the user has the given role
     */
    public function hasRole($role) {
        return null != $this->roles()->whereIn('name', $role)->first();
    }
}
