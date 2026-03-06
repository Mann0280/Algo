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
        Schema::table('signals', function (Blueprint $table) {
            $table->string('type')->after('stock_symbol')->default('BUY'); // BUY or SELL
            $table->decimal('close_price', 15, 2)->nullable()->after('target_2');
            $table->string('result')->nullable()->after('close_price'); // WIN, LOSS, BREAKEVEN
            $table->decimal('pl', 15, 2)->nullable()->after('result');
            $table->string('status')->default('open')->after('pl'); // open, closed
            $table->timestamp('closed_at')->nullable()->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('signals', function (Blueprint $table) {
            //
        });
    }
};
