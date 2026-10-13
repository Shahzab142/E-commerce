<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['easypaisa', 'jazzcash', 'bank']);
            $table->string('account_title');
            $table->string('account_number');
            $table->string('bank_name')->nullable();
            $table->string('iban')->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();
            // Soft deletes: a customer deleting a saved method only hides it —
            // the record stays in the database for records/audit purposes.
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_payment_methods');
    }
};
