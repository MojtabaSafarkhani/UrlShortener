<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class LinkResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'url' => $this->url,
            'slug' => $this->slug,
            'user' => new UserResource($this->whenLoaded('user')),
        ];
    }
}
