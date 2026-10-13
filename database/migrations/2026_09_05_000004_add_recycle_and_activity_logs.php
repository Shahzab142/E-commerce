<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |----------------------------------------------------------------------
        | Soft deletes + actor tracking (Recycle Bin support)
        |----------------------------------------------------------------------
        */
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('deleted_by')->nullable()->after('placed_at');
            $table->softDeletes()->after('deleted_by');
        });

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('deleted_by')->nullable()->after('status');
            $table->softDeletes()->after('deleted_by');
        });

        /*
        |----------------------------------------------------------------------
        | Activity log (vendor/admin actions visible to admin)
        |----------------------------------------------------------------------
        */
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('actor_id')->index();
            $table->string('actor_role', 20)->default('vendor'); // vendor | admin
            $table->string('action', 50)->index();               // order.deleted, user.approved, ...
            $table->nullableMorphs('subject');
            $table->text('description');
            $table->json('metadata')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_logs');

        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['deleted_by', 'deleted_at']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['deleted_by', 'deleted_at']);
        });
    }
};
