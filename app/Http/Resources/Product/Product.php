<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Resources\Json\JsonResource;

class Product extends JsonResource
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
            'image' => $this->image,
            'product_name' => $this->product_name,
            'unit_price'=> $this->unit_price,
            'quantity'=> $this->quantity,
            'store'=> $this->store,
            'category_id'=> $this->category_id,
            
        ];
    }
}
