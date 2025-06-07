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
        Schema::create('key_switches', function (Blueprint $table) {
            $table->id();
            $table->string('name')->comment('Switch name');
            $table->string('brand')->comment('Manufacturer brand');
            $table->string('type', 50)->comment('Linear, Tactile, Clicky');
            $table->decimal('price', 8, 2)->nullable()->comment('Price in currency');
            $table->string('image_url', 500)->nullable()->comment('Product image URL');
            $table->text('description')->nullable()->comment('Product description');
            $table->decimal('operating_force', 5, 2)->nullable()->comment('Operating force in grams');
            $table->decimal('bottom_out_force', 5, 2)->nullable()->comment('Bottom out force in grams');
            $table->decimal('total_travel', 4, 2)->nullable()->comment('Total travel distance in mm');
            $table->boolean('is_active')->default(true)->comment('Whether the switch is active');
            $table->timestamps();
            
            // Add indexes for common queries
            $table->index(['brand', 'type']);
            $table->index('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('key_switches');
    }
};
