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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('key_switch_id')->constrained('key_switches')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->integer('pitch')->comment('-100 to 100 range for sound pitch');
            $table->integer('depth')->comment('-100 to 100 range for sound depth');
            $table->text('text')->comment('Review text content');
            $table->unsignedInteger('likes_count')->default(0)->comment('Number of likes');
            $table->boolean('is_published')->default(true)->comment('Whether the review is published');
            $table->timestamps();
            
            // Unique constraint: one review per user per switch
            $table->unique(['key_switch_id', 'user_id']);
            
            // Add indexes for common queries
            $table->index(['key_switch_id', 'is_published']);
            $table->index(['user_id', 'is_published']);
            $table->index('is_published');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
