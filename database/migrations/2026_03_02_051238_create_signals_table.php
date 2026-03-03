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
        Schema::create('signals', function (Blueprint $table) {
            $table->id();
            $table->string('stock_symbol');
            $table->string('risk_level')->default('Low');
            $table->decimal('entry_price', 15, 2);
            $table->decimal('stop_loss', 15, 2);
            $table->decimal('target_1', 15, 2);
            $table->decimal('target_2', 15, 2);
            $table->integer('confidence_level');
            $table->boolean('is_premium')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('signals');
    }
};
