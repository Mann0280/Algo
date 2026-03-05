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
        Schema::table('users', function (Blueprint $table) {
            $table->string('risk_strategy')->default('Aggressive');
            $table->string('default_allocation')->default('50000');
            $table->decimal('sl_threshold', 5, 2)->default(2.45);
            $table->decimal('signal_sensitivity', 5, 2)->default(0.82);
            $table->integer('neural_confidence')->default(75);
            $table->decimal('learning_rate', 8, 4)->default(0.005);
            $table->string('pattern_depth')->default('V4.2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'risk_strategy',
                'default_allocation',
                'sl_threshold',
                'signal_sensitivity',
                'neural_confidence',
                'learning_rate',
                'pattern_depth'
            ]);
        });
    }
};
