<?php

namespace App\Http\Entities;

class PostQueryEntity extends PaginateQueryEntity
{
    public function __construct(
        string $page,
        string $limit,
        private ?string $title = '',

    )
    {
        parent::__construct($page, $limit);
    }

    public function getQueryTitle()
    {
        return $this->title;
    }
}
