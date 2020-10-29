<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserCollectionResource extends JsonResource
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
            "id"        => $this->id,
            "name"      => $this->name,
            "email"     => $this->email,
            "bio"       => $this->bio ? $this->bio : '',
            "profilePic"=> $this->getProfilePicUrl($this),
            "created_at"=> date('d-m-Y', strtotime($this->created_at)),
            "business"  => BusinessCollectionResource::collection($this->business),
        ];
        return $resource;
    }
}
