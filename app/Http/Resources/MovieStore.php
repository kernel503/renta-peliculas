<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MovieStore extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'movie_name' => $this->movie_name,
            'release_date' => $this->release_date,
            'img_url' => $this->img_url,
            'quantity_stock' => $this->quantity_stock,
            'sale_price' => $this->sale_price,
            'rent_price' => $this->rent_price,
            'category_name' => $this->category_name
        ];
        return parent::toArray($request);
    }
}
