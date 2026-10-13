<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vendor_details', function (Blueprint $table) {
            $table->string('id_number')->nullable()->after('business_address');
            $table->string('country')->nullable()->after('business_phone');
            $table->string('state')->nullable()->after('country');
            $table->string('city')->nullable()->after('state');
            $table->string('postal_code')->nullable()->after('city');
            $table->text('personal_address')->nullable()->after('postal_code');
            $table->text('business_description')->nullable()->after('business_address');
            $table->string('established_year', 4)->nullable()->after('business_description');
        });
    }

    public function down(): void
    {
        Schema::table('vendor_details', function (Blueprint $table) {
            $table->dropColumn([
                'id_number',
                'country',
                'state',
                'city',
                'postal_code',
                'personal_address',
                'business_description',
                'established_year',
            ]);
        });
    }
};