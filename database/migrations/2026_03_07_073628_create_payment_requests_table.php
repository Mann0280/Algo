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
        Schema::create('payment_requests', function (Blueprint $table) {
            $table->id();
            $table->string('type')->default('upgrade'); // 'upgrade' or 'topup'
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('package_id')->nullable()->constrained('premium_packages')->onDelete('cascade');
            $table->string('plan_name')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('utr_number')->unique()->nullable();
            $table->string('payment_screenshot')->nullable();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->text('rejection_note')->nullable();
            $table->timestamp('verified_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_requests');
    }
};
