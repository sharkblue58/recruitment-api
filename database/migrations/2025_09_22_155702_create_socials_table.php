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
        Schema::create('socials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->string('provider'); // e.g., 'google', 'facebook', 'linkedin'
            $table->string('provider_id')->nullable(); // ID from the social provider
            $table->string('avatar')->nullable(); // URL to avatar image
            $table->timestamps();
            
            // Add unique constraint to prevent duplicate social accounts
            $table->unique(['user_id', 'provider'], 'user_provider_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('socials');
    }
};