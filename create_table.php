<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$kernel->bootstrap();

try {
    Illuminate\Support\Facades\DB::statement("
        CREATE TABLE payment_requests (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            user_id BIGINT UNSIGNED NOT NULL,
            package_id BIGINT UNSIGNED NOT NULL,
            plan_name VARCHAR(255) NOT NULL,
            amount DECIMAL(10, 2) NOT NULL,
            utr_number VARCHAR(255) NOT NULL UNIQUE,
            payment_screenshot VARCHAR(255) NOT NULL,
            status ENUM('pending', 'approved', 'rejected') NOT NULL DEFAULT 'pending',
            rejection_note TEXT NULL,
            verified_at TIMESTAMP NULL,
            created_at TIMESTAMP NULL,
            updated_at TIMESTAMP NULL,
            CONSTRAINT fk_user_req FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            CONSTRAINT fk_package_req FOREIGN KEY (package_id) REFERENCES premium_packages(id) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
    ");
    echo "Table Created Successfully";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
