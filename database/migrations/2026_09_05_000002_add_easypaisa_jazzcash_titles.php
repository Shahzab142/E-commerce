<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->string('easypaisa_account_title')->nullable()->after('easypaisa_number');
            $table->string('jazzcash_account_title')->nullable()->after('jazzcash_number');
        });

        Schema::table('vendor_details', function (Blueprint $table) {
            $table->string('easypaisa_account_title')->nullable()->after('easypaisa_number');
            $table->string('jazzcash_account_title')->nullable()->after('jazzcash_number');
        });
    }

    public function down(): void
    {
        Schema::table('admin_details', function (Blueprint $table) {
            $table->dropColumn(['easypaisa_account_title', 'jazzcash_account_title']);
        });

        Schema::table('vendor_details', function (Blueprint $table) {
            $table->dropColumn(['easypaisa_account_title', 'jazzcash_account_title']);
        });
    }
};