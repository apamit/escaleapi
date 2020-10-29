<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessCollectionResource extends JsonResource
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
            "id"                => $this->id,
            "user_id"           => $this->user_id,
            "company_name"      => $this->company_name,
            "email"             => $this->email,
            "registration_no"   => $this->registration_no,
            "created_at"        => date('d-m-Y', strtotime($this->created_at)),
            "product"           => ProductCollectionResource::collection($this->product),
        ];

        return $resource;
    }
}
