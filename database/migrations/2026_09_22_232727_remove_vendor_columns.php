<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('vendor_details');

        if (DB::getDriverName() === 'sqlite') {
            DB::statement('DROP INDEX IF EXISTS products_vendor_id_status_index');
            DB::statement('DROP INDEX IF EXISTS orders_vendor_id_status_index');
            DB::statement('DROP INDEX IF EXISTS coupons_vendor_id_scope_index');
        }

        if (Schema::hasColumn('products', 'vendor_id')) {
            try {
                Schema::table('products', function (Blueprint $table) {
                    $table->dropIndex(['vendor_id', 'status']);
                });
            } catch (\Throwable $e) {}

            Schema::table('products', function (Blueprint $table) {
                try {
                    $table->dropForeign(['vendor_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('vendor_id');
            });
        }

        if (Schema::hasColumn('orders', 'vendor_id')) {
            try {
                Schema::table('orders', function (Blueprint $table) {
                    $table->dropIndex(['vendor_id', 'status']);
                });
            } catch (\Throwable $e) {}

            Schema::table('orders', function (Blueprint $table) {
                try {
                    $table->dropForeign(['vendor_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('vendor_id');
            });
        }

        if (Schema::hasColumn('coupons', 'vendor_id')) {
            try {
                Schema::table('coupons', function (Blueprint $table) {
                    $table->dropIndex(['vendor_id', 'scope']);
                });
            } catch (\Throwable $e) {}

            Schema::table('coupons', function (Blueprint $table) {
                try {
                    $table->dropForeign(['vendor_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('vendor_id');
            });
        }

        if (Schema::hasColumn('product_questions', 'vendor_id')) {
            Schema::table('product_questions', function (Blueprint $table) {
                try {
                    $table->dropForeign(['vendor_id']);
                } catch (\Throwable $e) {}
                $table->dropColumn('vendor_id');
            });
        }
    }

    public function down(): void
    {
        // No reverse needed since we want this permanently gone.
    }
};
