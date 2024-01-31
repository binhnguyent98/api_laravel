<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginationResource extends ResourceCollection
{
    protected $data;

    public function toArray($request)
    {
        return [
            'paginate' => [
                'total' => $this->total(),
                'page' => $this->currentPage(),
                'perPage' => $this->perPage()
            ],
            'items' => $this->data,
        ];
    }
}
