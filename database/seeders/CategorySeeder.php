<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'id' => 1,
                'title' => 'News',
                'level' => 0
            ],
            [
                'id' => 2,
                'title' => 'Society',
                'level' => 0
            ],
            [
                'id' => 3,
                'title' => 'Social',
                'level' => 0
            ],
            [
                'id' => 4,
                'title' => 'Body',
                'level' => 1
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
