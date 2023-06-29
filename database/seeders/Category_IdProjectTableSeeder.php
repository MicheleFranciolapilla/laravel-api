<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin\Project as Project;
use App\Models\Admin\Category as Category;

class Category_IdProjectTableSeeder extends Seeder
{
    public function run()
    {
        $projects = Project::all();
        $categories = Category::all();
        foreach ($projects as $project)   
        {
            $category = mt_rand(0,count($categories));
            if ($category === 0)
                $project->category_id = null;
            else
                $project->category_id = $categories[$category - 1]->id;
            $project->update(); 
        }
    }
}
