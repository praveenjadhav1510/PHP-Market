<?php
// config/setup_tables.php
// Run this file once to create all necessary database tables
// Access via: http://localhost/php-dev-marketplace/config/setup_tables.php

require_once __DIR__ . '/db.php';

$errors = [];
$success = [];

echo "<!DOCTYPE html><html><head><title>Database Setup</title>";
echo "<style>body{font-family:Arial;max-width:800px;margin:50px auto;padding:20px;}";
echo ".success{background:#d4edda;color:#155724;padding:10px;margin:10px 0;border-radius:5px;}";
echo ".error{background:#f8d7da;color:#721c24;padding:10px;margin:10px 0;border-radius:5px;}";
echo ".info{background:#d1ecf1;color:#0c5460;padding:10px;margin:10px 0;border-radius:5px;}";
echo "h1{color:#333;} pre{background:#f4f4f4;padding:10px;border-radius:5px;overflow-x:auto;}</style></head><body>";
echo "<h1>🔧 Database Setup - PHP Dev Marketplace</h1>";

try {
    // 1. Create payments table
    echo "<div class='info'>Creating payments table...</div>";
    $sql = "CREATE TABLE IF NOT EXISTS payments (
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
        INDEX idx_user_id (user_id),
        INDEX idx_payment_status (payment_status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $pdo->exec($sql);
    $success[] = "✅ Payments table created successfully";
    
    // Add foreign key constraint if users table exists
    try {
        $pdo->exec("ALTER TABLE payments ADD CONSTRAINT fk_payments_user FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE");
        $success[] = "✅ Foreign key constraint added to payments table";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            $errors[] = "⚠️ Foreign key constraint: " . $e->getMessage();
        }
    }
    
    // 2. Ensure users table has plan column
    echo "<div class='info'>Checking users table structure...</div>";
    try {
        $pdo->exec("ALTER TABLE users ADD COLUMN plan ENUM('free','pro','premium') DEFAULT 'free'");
        $success[] = "✅ Added 'plan' column to users table";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate column name') !== false) {
            $success[] = "✅ Users table already has 'plan' column";
        } else {
            $errors[] = "⚠️ Users table plan column: " . $e->getMessage();
        }
    }
    
    // 3. Create project_applications table if not exists
    echo "<div class='info'>Creating project_applications table...</div>";
    $sql = "CREATE TABLE IF NOT EXISTS project_applications (
        id INT AUTO_INCREMENT PRIMARY KEY,
        project_id INT NOT NULL,
        developer_id INT NOT NULL,
        proposal TEXT NOT NULL,
        expected_budget INT NULL,
        expected_days INT NULL,
        status ENUM('applied','approved','rejected') DEFAULT 'applied',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_project_id (project_id),
        INDEX idx_developer_id (developer_id),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $pdo->exec($sql);
    $success[] = "✅ Project applications table created successfully";
    
    // Add unique constraint if not exists
    try {
        $pdo->exec("ALTER TABLE project_applications ADD CONSTRAINT uniq_app_per_project_dev UNIQUE (project_id, developer_id)");
        $success[] = "✅ Unique constraint added to project_applications";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            $errors[] = "⚠️ Unique constraint: " . $e->getMessage();
        }
    }
    
    // Add foreign keys if tables exist
    try {
        $pdo->exec("ALTER TABLE project_applications ADD CONSTRAINT fk_app_project FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE");
        $success[] = "✅ Foreign key added: project_applications -> projects";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false && strpos($e->getMessage(), 'already exists') === false) {
            $errors[] = "⚠️ Foreign key fk_app_project: " . $e->getMessage();
        }
    }
    
    try {
        $pdo->exec("ALTER TABLE project_applications ADD CONSTRAINT fk_app_developer FOREIGN KEY (developer_id) REFERENCES users(id) ON DELETE CASCADE");
        $success[] = "✅ Foreign key added: project_applications -> users";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false && strpos($e->getMessage(), 'already exists') === false) {
            $errors[] = "⚠️ Foreign key fk_app_developer: " . $e->getMessage();
        }
    }
    
    // 4. Create project_assignments table if not exists
    echo "<div class='info'>Creating project_assignments table...</div>";
    $sql = "CREATE TABLE IF NOT EXISTS project_assignments (
        id INT AUTO_INCREMENT PRIMARY KEY,
        project_id INT NOT NULL,
        developer_id INT NOT NULL,
        started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        completed_at TIMESTAMP NULL,
        status ENUM('in_progress','completed') DEFAULT 'in_progress',
        INDEX idx_project_id (project_id),
        INDEX idx_developer_id (developer_id),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $pdo->exec($sql);
    $success[] = "✅ Project assignments table created successfully";
    
    // Add unique constraint if not exists
    try {
        $pdo->exec("ALTER TABLE project_assignments ADD CONSTRAINT uniq_assignment_per_project UNIQUE (project_id)");
        $success[] = "✅ Unique constraint added to project_assignments";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            $errors[] = "⚠️ Unique constraint: " . $e->getMessage();
        }
    }
    
    // Add foreign keys if tables exist
    try {
        $pdo->exec("ALTER TABLE project_assignments ADD CONSTRAINT fk_assign_project FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE");
        $success[] = "✅ Foreign key added: project_assignments -> projects";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false && strpos($e->getMessage(), 'already exists') === false) {
            $errors[] = "⚠️ Foreign key fk_assign_project: " . $e->getMessage();
        }
    }
    
    try {
        $pdo->exec("ALTER TABLE project_assignments ADD CONSTRAINT fk_assign_developer FOREIGN KEY (developer_id) REFERENCES users(id) ON DELETE CASCADE");
        $success[] = "✅ Foreign key added: project_assignments -> users";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false && strpos($e->getMessage(), 'already exists') === false) {
            $errors[] = "⚠️ Foreign key fk_assign_developer: " . $e->getMessage();
        }
    }
    
    // 5. Create project_invitations table if not exists
    echo "<div class='info'>Creating project_invitations table...</div>";
    $sql = "CREATE TABLE IF NOT EXISTS project_invitations (
        id INT AUTO_INCREMENT PRIMARY KEY,
        project_id INT NOT NULL,
        developer_id INT NOT NULL,
        client_id INT NOT NULL,
        message TEXT NULL,
        status ENUM('pending','accepted','rejected') DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_project_id (project_id),
        INDEX idx_developer_id (developer_id),
        INDEX idx_client_id (client_id),
        INDEX idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4";
    
    $pdo->exec($sql);
    $success[] = "✅ Project invitations table created successfully";
    
    // Add unique constraint if not exists
    try {
        $pdo->exec("ALTER TABLE project_invitations ADD CONSTRAINT uniq_invite_per_project_dev UNIQUE (project_id, developer_id)");
        $success[] = "✅ Unique constraint added to project_invitations";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false) {
            $errors[] = "⚠️ Unique constraint: " . $e->getMessage();
        }
    }
    
    // Add foreign keys if tables exist
    try {
        $pdo->exec("ALTER TABLE project_invitations ADD CONSTRAINT fk_invite_project FOREIGN KEY (project_id) REFERENCES projects(id) ON DELETE CASCADE");
        $success[] = "✅ Foreign key added: project_invitations -> projects";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false && strpos($e->getMessage(), 'already exists') === false) {
            $errors[] = "⚠️ Foreign key fk_invite_project: " . $e->getMessage();
        }
    }
    
    try {
        $pdo->exec("ALTER TABLE project_invitations ADD CONSTRAINT fk_invite_developer FOREIGN KEY (developer_id) REFERENCES users(id) ON DELETE CASCADE");
        $success[] = "✅ Foreign key added: project_invitations -> users (developer)";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false && strpos($e->getMessage(), 'already exists') === false) {
            $errors[] = "⚠️ Foreign key fk_invite_developer: " . $e->getMessage();
        }
    }
    
    try {
        $pdo->exec("ALTER TABLE project_invitations ADD CONSTRAINT fk_invite_client FOREIGN KEY (client_id) REFERENCES users(id) ON DELETE CASCADE");
        $success[] = "✅ Foreign key added: project_invitations -> users (client)";
    } catch (PDOException $e) {
        if (strpos($e->getMessage(), 'Duplicate key name') === false && strpos($e->getMessage(), 'already exists') === false) {
            $errors[] = "⚠️ Foreign key fk_invite_client: " . $e->getMessage();
        }
    }
    
    // 6. Verify all tables exist
    echo "<div class='info'>Verifying tables...</div>";
    $requiredTables = ['payments', 'users', 'projects', 'project_applications', 'project_assignments', 'project_invitations'];
    $existingTables = [];
    
    $stmt = $pdo->query("SHOW TABLES");
    while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
        $existingTables[] = $row[0];
    }
    
    echo "<h2>📊 Table Status</h2>";
    foreach ($requiredTables as $table) {
        if (in_array($table, $existingTables)) {
            echo "<div class='success'>✅ Table '$table' exists</div>";
        } else {
            echo "<div class='error'>❌ Table '$table' is missing</div>";
        }
    }
    
    // Display results
    echo "<h2>✅ Setup Complete!</h2>";
    
    if (!empty($success)) {
        echo "<h3>Success Messages:</h3>";
        foreach ($success as $msg) {
            echo "<div class='success'>$msg</div>";
        }
    }
    
    if (!empty($errors)) {
        echo "<h3>Warnings (non-critical):</h3>";
        foreach ($errors as $msg) {
            echo "<div class='error'>$msg</div>";
        }
    }
    
    echo "<div class='info' style='margin-top:30px;'>";
    echo "<strong>🎉 Database setup completed!</strong><br>";
    echo "You can now use the payment system. Both clients and developers can purchase plans.<br>";
    echo "<a href='/php-dev-marketplace/'>Go to Homepage</a> | ";
    echo "<a href='/php-dev-marketplace/dashboard/upgrade'>View Plans</a>";
    echo "</div>";
    
} catch (PDOException $e) {
    echo "<div class='error'>";
    echo "<h3>❌ Error:</h3>";
    echo "<pre>" . htmlspecialchars($e->getMessage()) . "</pre>";
    echo "</div>";
}

echo "</body></html>";


