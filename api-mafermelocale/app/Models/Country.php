<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Country extends Model
{
    use HasFactory, HasApiTokens;

    protected $fillable = [
        'name',
        'iso_code',
        'currency_id'
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
}
