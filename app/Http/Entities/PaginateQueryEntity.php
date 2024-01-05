<?php

namespace App\Http\Entities;

use Illuminate\Support\Facades\Hash;

class PaginateQueryEntity
{
    public function __construct(
        private string $page,
        private string $limit,
    )
    { }

    public function getPage()
    {
        return $this->page ? (int)$this->page : config('paginate.page_default');
    }

    public function getLimit()
    {
        return $this->limit ? (int)$this->limit : config('paginate.per_page_default');
    }

}
