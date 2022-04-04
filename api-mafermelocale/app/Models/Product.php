<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'product_name',
        'price',
        'product_image',
        'category_id',
        'farm_id',
        'lang_id'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function farm()
    {
        return $this->belongsTo(Farm::class);
    }

    public function lang()
    {
        return $this->belongsTo(Lang::class);
    }
}
