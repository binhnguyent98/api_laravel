<?php

namespace Database\Factories;

use App\Models\Creator;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Creator>
 */
class CreatorFactory extends Factory
{
    protected $model = Creator::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        static $number = 1;

        return [
            'user_id' => 1,
            'post_id' => $number++
        ];
    }
}
