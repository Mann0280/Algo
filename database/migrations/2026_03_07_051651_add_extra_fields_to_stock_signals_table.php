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
        Schema::table('stock_signals', function (Blueprint $table) {
            $table->string('signal_type', 10)->after('stock_name')->default('BUY'); // BUY or SELL
            $table->decimal('close_price', 10, 2)->after('sl')->nullable();
            $table->string('result', 20)->after('close_price')->nullable(); // WIN, LOSS, BREAKEVEN, RUNNING
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('stock_signals', function (Blueprint $table) {
            $table->dropColumn(['signal_type', 'close_price', 'result']);
        });
    }
};
