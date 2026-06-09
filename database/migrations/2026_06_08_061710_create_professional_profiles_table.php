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
        Schema::create('professional_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name');
            $table->string('specialty');
            $table->text('bio')->nullable();
            $table->integer('experience_years')->default(0);
            $table->string('location')->nullable();
            $table->string('phone')->nullable();
            $table->double('rating', 3, 1)->default(5.0);
            $table->integer('completed_jobs')->default(0);
            $table->string('image_path')->nullable();
            $table->double('total_earnings')->default(0);
            $table->double('payout_balance')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_profiles');
    }
};
