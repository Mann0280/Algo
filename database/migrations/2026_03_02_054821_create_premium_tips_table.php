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
        Schema::create('premium_tips', function (Blueprint $table) {
            $table->id();
            $table->string('stock_name');
            $table->decimal('entry_price', 15, 2);
            $table->decimal('target_1', 15, 2);
            $table->decimal('target_2', 15, 2)->nullable();
            $table->decimal('target_3', 15, 2)->nullable();
            $table->decimal('stop_loss', 15, 2);
            $table->integer('confidence_percentage');
            $table->string('risk_level'); // Low, Medium, High
            $table->string('trade_type'); // Intraday, Swing, Long Term
            $table->string('status')->default('Active'); // Active, Achieved, SL Hit, Closed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('premium_tips');
    }
};
