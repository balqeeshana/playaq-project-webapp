<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('professional_profile_id')->constrained('professional_profiles')->onDelete('cascade');
            $table->string('service_name');
            $table->text('description');
            $table->date('booking_date');
            $table->string('booking_time');
            $table->double('deposit_amount');
            $table->string('total_estimated_cost')->nullable();
            $table->string('status')->default('pending');
            $table->integer('rating')->nullable();
            $table->text('review_comment')->nullable();
            $table->text('photo_paths')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
