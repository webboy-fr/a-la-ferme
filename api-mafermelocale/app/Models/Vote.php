<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Vote extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'vote',
        'farm_id',
        'user_id',
    ];

    public function farm() {
        return $this->belongsTo(Farm::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
