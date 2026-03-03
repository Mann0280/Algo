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
        Schema::create('trading_tips', function (Blueprint $table) {
            $table->id();
            $table->string('stock_name');
            $table->decimal('entry_price', 10, 2);
            $table->decimal('stop_loss', 10, 2);
            $table->decimal('target_price', 10, 2);
            $table->enum('status', ['LIVE', 'RUNNING', 'HIT TARGET', 'SL HIT'])->default('LIVE');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trading_tips');
    }
};
