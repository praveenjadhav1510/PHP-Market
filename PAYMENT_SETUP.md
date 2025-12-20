# Payment System Setup Guide

## 🚀 Quick Setup

### Step 1: Create Database Tables

Visit this URL in your browser to automatically create all required tables:
```
http://localhost/php-dev-marketplace/config/setup_tables.php
```

This will create:
- ✅ `payments` table (for tracking transactions)
- ✅ `project_applications` table (if not exists)
- ✅ `project_assignments` table (if not exists)
- ✅ Adds `plan` column to `users` table (if not exists)

### Step 2: Test Payment

1. **Login** as either a client or developer
2. Go to **Dashboard → Plans** (or visit `/php-dev-marketplace/dashboard/upgrade`)
3. Click **"Upgrade to Pro"** or **"Go Premium"**
4. Fill in the payment form with **test data**:
   - Card Number: `4111 1111 1111 1111` (or any number)
   - Expiry: `12/25` (or any future date)
   - CVV: `123` (or any 3-4 digits)
   - Name: Any name
5. Click **Pay** - payment will be processed in test mode

## 📋 Required Tables

### 1. Payments Table
```sql
CREATE TABLE payments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    plan ENUM('free','pro','premium') NOT NULL,
    amount DECIMAL(10,2) NOT NULL,
    payment_id VARCHAR(255) NULL,
    payment_status ENUM('pending','success','failed','refunded') DEFAULT 'pending',
    payment_method VARCHAR(50) NULL,
    transaction_id VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);
```

### 2. Users Table (should have `plan` column)
```sql
ALTER TABLE users ADD COLUMN plan ENUM('free','pro','premium') DEFAULT 'free';
```

### 3. Project Applications Table (if not exists)
```sql
CREATE TABLE project_applications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    developer_id INT NOT NULL,
    proposal TEXT NOT NULL,
    expected_budget INT NULL,
    expected_days INT NULL,
    status ENUM('applied','approved','rejected') DEFAULT 'applied',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

### 4. Project Assignments Table (if not exists)
```sql
CREATE TABLE project_assignments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    project_id INT NOT NULL,
    developer_id INT NOT NULL,
    started_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    completed_at TIMESTAMP NULL,
    status ENUM('in_progress','completed') DEFAULT 'in_progress'
);
```

## 💳 Payment Plans

| Plan | Price | Features |
|------|-------|----------|
| **Free** | ₹0/month | 3 projects, 5 applications, basic features |
| **Pro** | ₹199/month | 20 projects, 50 applications, priority visibility, direct messaging |
| **Premium** | ₹999/month | Unlimited projects/applications, featured listings, analytics |

## ✅ Who Can Purchase?

**Both clients and developers** can purchase any plan:
- ✅ Clients can upgrade to post more projects
- ✅ Developers can upgrade to submit more applications
- ✅ All premium features work for both user types

## 🧪 Test Mode

The payment system is currently in **test mode**:
- ✅ No real payment gateway integration
- ✅ Accepts any card number
- ✅ Payment always succeeds
- ✅ Plan activated immediately

## 🔧 Troubleshooting

### Error: "Table 'payments' doesn't exist"
**Solution:** Run the setup script:
```
http://localhost/php-dev-marketplace/config/setup_tables.php
```

### Error: "Cannot modify header information"
**Solution:** Make sure no output is sent before redirects. Check for:
- Whitespace before `<?php` tags
- Echo statements before headers
- BOM characters in files

### Payment Not Processing
1. Check database connection in `config/db.php`
2. Verify `payments` table exists
3. Check PHP error logs
4. Ensure user is logged in

## 📁 Files Created

- `config/setup_tables.php` - Auto-setup script
- `config/payment_config.php` - Plan configuration
- `payment/payment.php` - Payment form
- `payment/process.php` - Payment processing
- `payment/success.php` - Success page
- `payment/failure.php` - Failure page
- `payment/downgrade.php` - Downgrade handler
- `includes/plan-check.php` - Plan feature checks

## 🎯 Next Steps

1. ✅ Run setup script to create tables
2. ✅ Test payment as both client and developer
3. ✅ Verify plan restrictions work
4. (Optional) Integrate real payment gateway (Razorpay/Stripe)

---

**Need Help?** Check the setup script output for detailed status of each table.




