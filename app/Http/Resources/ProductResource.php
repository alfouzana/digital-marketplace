<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
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
            'title' => $this->title,
            'body' => (string )$this->body,
            'price' => $this->price,
            'cover_url' => $this->cover->url(),
            'sample_url' => $this->sample->url(),
            'category' => $this->category->name,
            'user' => $this->vendor->name,
            'approval_status' => $this->approval_status,
            'approval_context' => $this->approval_context,
            'created_at' => $this->created_at,
            'updated_at'=> $this->updated_at,
            'deleted_at' => $this->deleted_at,
            'approval_at' => $this->approval_at,
        ];
    }
}
