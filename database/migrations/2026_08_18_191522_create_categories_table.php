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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();

            // Category Information
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('short_description', 160)->nullable();
            $table->text('description')->nullable();

            // Visibility
            $table->enum('status', [
                'published',
                'draft',
                'hidden',
            ])->default('draft');

            // Homepage visibility
            $table->boolean('show_on_homepage')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};