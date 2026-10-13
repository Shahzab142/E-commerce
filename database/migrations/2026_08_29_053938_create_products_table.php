<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {

            $table->id();

            // Product Information
            $table->string('name');
            $table->string('sku')->unique();
            $table->string('barcode')->nullable();

            $table->text('short_description')->nullable();
            $table->longText('description')->nullable();

            // Pricing
            $table->decimal('regular_price', 12, 2);
            $table->decimal('sale_price', 12, 2)->nullable();

            // Inventory
            $table->unsignedInteger('quantity')->default(0);

            $table->enum('stock_status', [
                'in_stock',
                'out_of_stock'
            ])->default('in_stock');

            // Category
            $table->foreignId('category_id')
                ->nullable()
                ->constrained('categories')
                ->nullOnDelete();

           

            // Product Status
            $table->enum('status', [
                'draft',
                'published',
                'pending'
            ])->default('draft');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};