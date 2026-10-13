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
        Schema::create('vendor_details', function (Blueprint $table) {
           $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->string('business_name');
        $table->string('business_type')->nullable();
        $table->string('business_address');
        $table->string('business_phone');
        $table->string('registration_number')->nullable();
        $table->string('tax_number')->nullable();
        $table->string('bank_name')->nullable();
        $table->string('account_title')->nullable();
        $table->string('account_number')->nullable();
        $table->string('iban')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_details');
    }
};
