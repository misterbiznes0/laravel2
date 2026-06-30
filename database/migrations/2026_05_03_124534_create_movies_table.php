<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('poster')->nullable();
            $table->integer('duration');
            $table->string('trailer_url')->nullable();
            $table->date('release_date');
            $table->string('age_rating')->default('12+');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movies');
    }
};