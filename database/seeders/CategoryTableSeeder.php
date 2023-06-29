<?php

namespace Database\Seeders;

use App\Models\Admin\Category as Category;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class CategoryTableSeeder extends Seeder
{
    public   $categories =
                [
                    'Api',
                    'Front End',
                    'Back End',
                    'Full Stack',
                    'Game',
                    'Responsive'
                ]; 

    public  function run()
    {
        foreach ($this->categories as $category)
        {
            $new_category = new Category();
            $new_category->name = $category;
            $new_category->slug = Str::slug($new_category->name,'-');
            $new_category->save();
        }
    }
}