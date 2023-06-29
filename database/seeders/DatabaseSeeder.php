<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(
            [
                ProjectTableSeeder::class,
                CategoryTableSeeder::class,
                Category_IdProjectTableSeeder::class,
                TechnologyTableSeeder::class,
                Project_TechnologyTableSeeder::class
            ]);
    }
}
