<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        try {
            DB::beginTransaction();
            $this->call([
                UserSeeder::class,
                CategorySeeder::class,
                PostSeeder::class,
                CreatorSeeder::class
            ]);
            DB::commit();
        } catch (error) {
            DB::rollBack();
        }
    }
}
