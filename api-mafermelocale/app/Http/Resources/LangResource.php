<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LangResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'iso_code' => $this->iso_code,
            'langage_local' => $this->langage_local,
            'date_format_lite' => $this->date_format_lite,
            'date_format_full' => $this->date_format_full,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
