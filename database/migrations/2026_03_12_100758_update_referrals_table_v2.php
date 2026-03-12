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
        Schema::table('referrals', function (Blueprint $table) {
            $table->string('plan_name')->nullable()->after('referred_user_id');
            $table->decimal('plan_amount', 10, 2)->nullable()->after('plan_name');
            $table->enum('status', ['pending', 'rewarded', 'rejected'])->default('pending')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('referrals', function (Blueprint $table) {
            $table->dropColumn(['plan_name', 'plan_amount']);
            // Enum change back is tricky in SQLite/MySQL without dbal
        });
    }
};
