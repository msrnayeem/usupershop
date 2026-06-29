# Database Update Queries

Run these SQL queries in your database (e.g. via phpMyAdmin or database client) to manually sync the database structure on the server.

---

## 1. Fix for the current error (User Login blocking)
Adds the missing login attempt tracking and block fields to your `users` table:

```sql
ALTER TABLE `users` 
  ADD COLUMN `failed_login_attempts` TINYINT DEFAULT 0 AFTER `status`,
  ADD COLUMN `login_blocked_at` TIMESTAMP NULL DEFAULT NULL AFTER `failed_login_attempts`,
  ADD COLUMN `login_blocked_reason` VARCHAR(300) NULL DEFAULT NULL AFTER `login_blocked_at`;
```

---

## 2. Soft Deletes (deleted_at columns)
Adds soft-delete columns to key tables for trash bin functionality:

```sql
ALTER TABLE `products` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `users` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `orders` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `coupons` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `sliders` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `categories` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL;
ALTER TABLE `pages` ADD COLUMN `deleted_at` TIMESTAMP NULL DEFAULT NULL;
```

---

## 3. Seller Referral on Orders
Adds referrer commission columns to track order referrals:

```sql
ALTER TABLE `orders` 
  ADD COLUMN `seller_ref_id` BIGINT UNSIGNED NULL DEFAULT NULL AFTER `user_id`,
  ADD COLUMN `seller_ref_commission` DECIMAL(10, 2) DEFAULT 0.00 AFTER `seller_ref_id`,
  ADD COLUMN `seller_ref_paid` TINYINT DEFAULT 0 AFTER `seller_ref_commission`;
```

---

## 4. Create Payment Logs Table
Creates logging tables for transaction events (like bKash):

```sql
CREATE TABLE IF NOT EXISTS `payment_logs` (
  `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  `payment_id` VARCHAR(100) NOT NULL,
  `trx_id` VARCHAR(100) NULL DEFAULT NULL,
  `invoice_no` VARCHAR(100) NULL DEFAULT NULL,
  `payment_type` VARCHAR(50) NOT NULL,
  `status` VARCHAR(20) NOT NULL,
  `amount` DECIMAL(12, 2) DEFAULT 0.00,
  `ip_address` VARCHAR(50) NULL DEFAULT NULL,
  `user_agent` VARCHAR(300) NULL DEFAULT NULL,
  `notes` TEXT NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  INDEX `payment_logs_payment_id_index` (`payment_id`),
  INDEX `payment_logs_trx_id_index` (`trx_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
```

---

## 5. Performance Indexes
Adds indexes for much faster page load performance:

```sql
CREATE INDEX `products_status_index` ON `products` (`status`);
CREATE INDEX `products_category_id_index` ON `products` (`category_id`);
CREATE INDEX `products_hot_deals_index` ON `products` (`hot_deals`);
CREATE INDEX `products_featured_index` ON `products` (`featured`);
CREATE INDEX `products_special_offer_index` ON `products` (`special_offer`);
CREATE INDEX `products_special_deals_index` ON `products` (`special_deals`);
CREATE INDEX `products_user_id_index` ON `products` (`user_id`);
CREATE INDEX `products_status_id_index` ON `products` (`status`, `id`);

CREATE INDEX `orders_user_id_index` ON `orders` (`user_id`);
CREATE INDEX `orders_delivery_status_index` ON `orders` (`delivery_status`);
CREATE INDEX `orders_payment_method_index` ON `orders` (`payment_method`);
CREATE INDEX `orders_user_status_index` ON `orders` (`user_id`, `delivery_status`);

CREATE INDEX `users_usertype_index` ON `users` (`usertype`);
CREATE INDEX `users_status_index` ON `users` (`status`);
CREATE INDEX `users_payment_status_index` ON `users` (`payment_status`);
CREATE INDEX `users_refer_code_index` ON `users` (`refer_code`);
CREATE INDEX `users_reseller_id_index` ON `users` (`reseller_id`);
CREATE INDEX `users_login_blocked_at_index` ON `users` (`login_blocked_at`);

CREATE INDEX `order_details_order_id_index` ON `order_details` (`order_id`);
CREATE INDEX `order_details_product_id_index` ON `order_details` (`product_id`);
CREATE INDEX `order_details_seller_id_index` ON `order_details` (`seller_id`);

CREATE INDEX `transactions_user_id_index` ON `transactions` (`user_id`);
CREATE INDEX `transactions_tnx_type_index` ON `transactions` (`tnx_type`);
CREATE INDEX `transactions_status_index` ON `transactions` (`status`);

CREATE INDEX `coupons_status_index` ON `coupons` (`status`);
CREATE INDEX `coupons_promoCode_index` ON `coupons` (`promoCode`);

CREATE INDEX `categories_is_show_index` ON `categories` (`is_show`);
```
