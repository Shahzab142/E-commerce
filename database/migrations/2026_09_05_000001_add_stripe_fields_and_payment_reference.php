<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->string('stripe_account_id')->nullable()->after('iban');
        });

        Schema::table('vendor_details', function (Blueprint $table) {
            $table->string('stripe_account_id')->nullable()->after('jazzcash_number');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_reference')->nullable()->after('payment_method');
            $table->index('payment_reference');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['payment_reference']);
            $table->dropColumn('payment_reference');
        });

        Schema::table('admin_details', function (Blueprint $table) {
            $table->dropColumn('stripe_account_id');
        });

        Schema::table('vendor_details', function (Blueprint $table) {
            $table->dropColumn('stripe_account_id');
        });
    }
};