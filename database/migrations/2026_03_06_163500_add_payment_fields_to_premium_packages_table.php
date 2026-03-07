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
        Schema::table('premium_packages', function (Blueprint $バランス) {
            $バランス->string('upi_name')->nullable()->after('upi_id');
            $バランス->string('qr_code')->nullable()->after('upi_name');
            $バランス->text('payment_info')->nullable()->after('qr_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('premium_packages', function (Blueprint $バランス) {
            $バランス->dropColumn(['upi_name', 'qr_code', 'payment_info']);
        });
    }
};
