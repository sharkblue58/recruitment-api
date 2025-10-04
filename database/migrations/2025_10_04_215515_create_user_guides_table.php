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
        Schema::create('user_guides', function (Blueprint $table) {
            $table->id();
            $table->json('heading'); // For storing Arabic and English headings
            $table->json('content'); // For storing Arabic and English content
            $table->enum('content_type', ['faq', 'terms_privacy']); // Content type enum
            $table->enum('target_audience', ['recruiters', 'candidates']); // Target audience enum
            $table->boolean('is_active')->default(true); // Active status
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['target_audience', 'content_type', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_guides');
    }
};
