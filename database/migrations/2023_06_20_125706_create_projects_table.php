<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) 
        {
            $table->id();
            $table->string('title',50)->unique();
            $table->string('slug',50)->unique();
            $table->text('description');
            $table->text('host_url')->nullable();
            $table->string('cover_img')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('projects');
    }
};
