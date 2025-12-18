-- SQL to add payments table for tracking transactions
-- Run this manually in your MySQL (e.g. via phpMyAdmin) against the `php_dev_marketplace` database.

CREATE TABLE IF NOT EXISTS payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan ENUM('free','pro','premium') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_id VARCHAR(255) NULL,
    payment_status ENUM('pending','success','failed','refunded') DEFAULT 'pending',
    payment_method VARCHAR(50) NULL,
    transaction_id VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_user_id (user_id),
    INDEX idx_payment_status (payment_status)
);

-- Add plan_expires_at to users table if not exists
-- ALTER TABLE users ADD COLUMN IF NOT EXISTS plan_expires_at TIMESTAMP NULL;



