<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Lang extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'iso_code',
        'langage_locale',
        'date_format_lite',
        'date_format_full'
    ];

    public function roles()
    {
        return $this->hasMany(Role::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function farm_details()
    {
        return $this->hasMany(Farm_details::class);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
