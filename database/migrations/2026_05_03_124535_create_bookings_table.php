<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('movie_session_id')->constrained('movie_sessions')->onDelete('cascade');
            $table->json('selected_seats');
            $table->decimal('total_price', 8, 2);
            $table->enum('status', ['pending', 'paid', 'cancelled'])->default('pending');
            $table->string('qr_code')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bookings');
    }
};