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
        'name',
        'farm_image',
        'short_description',
        'address_id',
        'farm_details_id',
        'user_id',
        'lang_id'
    ];

    public function lang() {
        return $this->belongsTo(Lang::class);
    }

    public function votes() {
        return $this->hasMany(Vote::class);
    }

    public function farm_detail()
    {
        return $this->hasOne(Farm_details::class, 'id', 'farm_details_id');
    }

    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
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
