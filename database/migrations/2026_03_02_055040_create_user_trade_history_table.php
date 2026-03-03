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
        Schema::create('user_trade_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('premium_tip_id')->constrained('premium_tips')->onDelete('cascade');
            $table->string('action'); // Buy, Sell, Book Profit, Cut Loss
            $table->decimal('profit_loss', 15, 2)->nullable();
            $table->timestamp('action_timestamp')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_trade_history');
    }
};
