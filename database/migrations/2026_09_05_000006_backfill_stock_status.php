<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Repair any products whose stock_status no longer matches quantity,
        // so the dashboard inventory alert is accurate immediately.
        DB::statement(
            "UPDATE products SET stock_status = CASE WHEN quantity > 0 THEN 'in_stock' ELSE 'out_of_stock' END"
        );
    }

    public function down(): void
    {
        // Nothing to reverse — the values are re-derived automatically.
    }
};
