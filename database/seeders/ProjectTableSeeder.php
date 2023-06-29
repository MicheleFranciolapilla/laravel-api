<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Admin\Project as Project;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectTableSeeder extends Seeder
{
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 30; $i++)
        {
            $new_project = new Project();
            $new_project->title = $faker->sentence(3);
            $new_project->slug = Str::slug($new_project->title, '-');
            $new_project->description = $faker->paragraph(5);
            $new_project->save();
        }
    }
}
