<?php

namespace Database\Seeders;

use App\Models\Admin\Technology as Technology;
use Illuminate\Database\Seeder;

use Illuminate\Support\Str;

class TechnologyTableSeeder extends Seeder
{
    public  $technologies =
                [
                    'Html',
                    'Css',
                    'Scss',
                    'Javascript',
                    'Vue',
                    'Php',
                    'Blade',
                    'Hack',
                    'Altre'
                ]; 
    public  $icons =
                [
                    '<i class="fa-brands fa-html5"></i>',
                    '<i class="fa-brands fa-css3-alt"></i>',
                    '<i class="fa-brands fa-sass"></i>',
                    '<i class="fa-brands fa-square-js"></i>',
                    '<i class="fa-brands fa-vuejs"></i>',
                    '<i class="fa-brands fa-php"></i>',
                    '<i class="fa-brands fa-laravel"></i>',
                    '<i class="fa-brands fa-stack-overflow"></i>',
                    '<i class="fa-solid fa-code"></i>'
                ];

    public  function run()
    {
        foreach ($this->technologies as $index => $technology)
        {
            $new_technology = new technology();
            $new_technology->name = $technology;
            $new_technology->slug = Str::slug($new_technology->name,'-');
            $new_technology->icon = $this->icons[$index];
            $new_technology->save();
        }
    }
}