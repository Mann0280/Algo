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
        Schema::create('stock_signals', function (Blueprint $table) {
            $table->id(); // Auto increment primary key

            $table->string('stock_name', 100);

            $table->decimal('entry', 10, 2);
            $table->decimal('target', 10, 2);
            $table->decimal('sl', 10, 2);
            $table->decimal('breakeven', 10, 2);

            $table->string('entry_time', 50);
            $table->string('entry_date', 50);

            $table->decimal('pnl', 10, 2)->nullable();

            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_signals');
    }
};
