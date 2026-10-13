<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->foreignId('vendor_id')
                ->nullable()
                ->after('category_id')
                ->constrained('users')
                ->nullOnDelete();

            $table->index(['vendor_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table): void {
            $table->dropForeign(['vendor_id']);
            $table->dropIndex(['vendor_id', 'status']);
            $table->dropColumn('vendor_id');
        });
    }
};