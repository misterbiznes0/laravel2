<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('movie_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained('movies')->onDelete('cascade');
            $table->foreignId('hall_id')->constrained('halls')->onDelete('cascade');
            $table->datetime('start_time');
            $table->datetime('end_time');
            $table->decimal('price', 8, 2);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movie_sessions');
    }
};