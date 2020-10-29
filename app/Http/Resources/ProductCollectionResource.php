<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $resource = [
            "id"          => $this->id,
            "business_id" => $this->business_id,
            "name"        => $this->name,
            "description" => $this->description,
            "mrp"         => $this->mrp,
            "created_at"  => date('d-m-Y', strtotime($this->created_at)),
            "images"      => $this->getProductImageUrl($this),
        ];

        return $resource;
    }
}
