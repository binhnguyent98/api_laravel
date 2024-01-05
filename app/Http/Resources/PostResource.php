<?php

namespace App\Http\Resources;

use App\Models\Post;

class PostResource extends PaginationResource
{
    public $collection = Post::class;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $this->data = $this->collection->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->title,
                'description' => $item->description,
                'category_name' => $item->category_name
            ];
        });

        return parent::toArray($request);
    }
}
