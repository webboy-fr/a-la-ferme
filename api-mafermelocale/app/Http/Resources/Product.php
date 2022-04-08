<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'product_image' => $this->product_image,
            'is_aop' => $this->is_aop,
            'is_aoc' => $this->is_aoc,
            'is_igp' => $this->is_igp,
            'is_stg' => $this->is_stg,
            'is_bio' => $this->is_bio,
            'is_labelrouge' => $this->is_labelrouge,
            'category_id' => $this->category_id,
            'farm_id' => $this->farm_id,
            'currency_id' => $this->currency_id,
            'lang_id' => $this->lang_id,
            'created_at' => $this->created_at->format('d/m/Y'),
            'updated_at' => $this->updated_at->format('d/m/Y'),
        ];
    }
}
