<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('halls', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('rows')->default(8);
            $table->integer('seats_per_row')->default(10);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('halls');
    }
};