<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Farm extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address_id',
        'farm_details_id',
        'user_id'
    ];

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function farm_detail()
    {
        return $this->hasOne(Farm_details::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
