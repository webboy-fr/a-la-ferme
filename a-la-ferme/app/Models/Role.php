<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    /**
     * 
     * A role can belong to many users (like there is 2 or 3 simple user and 2 admin)
     * 
     */
    public function users(){
        return $this->belongsToMany('App\Models\User');
    }
}
