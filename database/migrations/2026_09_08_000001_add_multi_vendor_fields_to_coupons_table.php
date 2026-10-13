<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->foreignId('vendor_id')->nullable()->constrained('users')->nullOnDelete()->after('is_active');
            $table->foreignId('product_id')->nullable()->constrained('products')->cascadeOnDelete()->after('vendor_id');
            $table->foreignId('category_id')->nullable()->constrained('categories')->cascadeOnDelete()->after('product_id');
            $table->foreignId('customer_id')->nullable()->constrained('users')->cascadeOnDelete()->after('category_id');
            $table->string('scope')->default('global')->after('customer_id');
            $table->index(['vendor_id', 'scope']);
            $table->index(['product_id', 'scope']);
            $table->index(['category_id', 'scope']);
            $table->index(['customer_id', 'scope']);
        });
    }

    public function down(): void
    {
        Schema::table('coupons', function (Blueprint $table) {
            $table->dropForeign(['vendor_id']);
            $table->dropForeign(['product_id']);
            $table->dropForeign(['category_id']);
            $table->dropForeign(['customer_id']);
            $table->dropColumn(['vendor_id', 'product_id', 'category_id', 'customer_id', 'scope']);
        });
    }
};
