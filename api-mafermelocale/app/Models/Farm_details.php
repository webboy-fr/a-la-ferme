<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Farm_details extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'farm_image',
        'name',
        'description',
        'about',
        'lang_id'
    ];

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class, null, 'farm_details_id');
    }
}
