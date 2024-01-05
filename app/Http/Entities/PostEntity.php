<?php

namespace App\Http\Entities;

class PostEntity
{
    public function __construct(
        private string $title,
        private string $description,
        private string $categoryId,
    )
    { }

    public function getTitle()
    {
        return $this->title;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCategoryId()
    {
        return (int)$this->categoryId;
    }
}
