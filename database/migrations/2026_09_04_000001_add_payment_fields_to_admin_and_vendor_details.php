<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->string('easypaisa_number')->nullable()->after('address');
            $table->string('jazzcash_number')->nullable()->after('easypaisa_number');
            $table->string('bank_name')->nullable()->after('jazzcash_number');
            $table->string('account_title')->nullable()->after('bank_name');
            $table->string('account_number')->nullable()->after('account_title');
            $table->string('iban')->nullable()->after('account_number');
        });

        Schema::table('vendor_details', function (Blueprint $table) {
            $table->string('easypaisa_number')->nullable()->after('iban');
            $table->string('jazzcash_number')->nullable()->after('easypaisa_number');
        });
    }

    public function down(): void
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->dropColumn([
                'easypaisa_number',
                'jazzcash_number',
                'bank_name',
                'account_title',
                'account_number',
                'iban',
            ]);
        });

        Schema::table('vendor_details', function (Blueprint $table) {
            $table->dropColumn([
                'easypaisa_number',
                'jazzcash_number',
            ]);
        });
    }
};
