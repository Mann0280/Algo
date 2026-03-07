<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

echo "Starting manual wallet migration...\n";

try {
    // 1. Add wallet_balance to users table
    if (!Schema::hasColumn('users', 'wallet_balance')) {
        Schema::table('users', function (Blueprint $table) {
            $table->decimal('wallet_balance', 10, 2)->after('remember_token')->default(0.00);
        });
        echo "Added wallet_balance to users table.\n";
    }

    // 2. Create wallet_transactions table
    if (!Schema::hasTable('wallet_transactions')) {
        Schema::create('wallet_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->enum('type', ['credit', 'debit']);
            $table->decimal('amount', 10, 2);
            $table->string('description');
            $table->string('status')->default('success');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        echo "Created wallet_transactions table.\n";
    } else {
        echo "wallet_transactions table already exists.\n";
    }

    echo "Manual wallet migration completed successfully.\n";
} catch (\Exception $e) {
    echo "Error during manual wallet migration: " . $e->getMessage() . "\n";
}
