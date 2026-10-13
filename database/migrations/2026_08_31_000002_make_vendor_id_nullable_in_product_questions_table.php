<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Make vendor_id nullable in product_questions.
     *
     * Products can exist without a vendor (products.vendor_id is nullable),
     * so questions asked on such products must be allowed to have no vendor.
     */
    public function up(): void
    {
        Schema::table('product_questions', function (Blueprint $table): void {
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('product_questions', function (Blueprint $table): void {
            $table->foreignId('vendor_id')->nullable()->change();

            $table->foreign('vendor_id')
                ->references('id')
                ->on('users')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('product_questions', function (Blueprint $table): void {
            $table->dropForeign(['vendor_id']);
        });

        Schema::table('product_questions', function (Blueprint $table): void {
            $table->foreignId('vendor_id')->change();

            $table->foreign('vendor_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }
};
