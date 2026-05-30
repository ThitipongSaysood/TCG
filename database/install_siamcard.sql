-- ============================================================
-- SIAMCARD MARKET — siamcard DB schema (MySQL/MariaDB)
-- Generated from Laravel migrations in database/migrations/siamcard/
-- Run on production: shop.siamcardmarket.com / DB: siamcard
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- 1. member (users) — auth + identity
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `member` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `display_name` VARCHAR(80) NOT NULL,
  `email` VARCHAR(160) NOT NULL,
  `phone` VARCHAR(20) NULL,
  `email_verified_at` TIMESTAMP NULL,
  `password` VARCHAR(255) NULL,
  `login_provider` ENUM('email','line','google') NOT NULL DEFAULT 'email',
  `provider_uid` VARCHAR(120) NULL,
  `avatar_url` VARCHAR(255) NULL,
  `membership_tier` ENUM('bronze','silver','gold','platinum') NOT NULL DEFAULT 'bronze',
  `total_spent` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `auction_wins` INT UNSIGNED NOT NULL DEFAULT 0,
  `role` ENUM('member','seller','admin') NOT NULL DEFAULT 'member',
  `status` ENUM('active','suspended') NOT NULL DEFAULT 'active',
  `remember_token` VARCHAR(100) NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `member_email_unique` (`email`),
  INDEX `member_provider_uid_login_provider_index` (`provider_uid`, `login_provider`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 2. password_reset_tokens — forgot password
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
  `email` VARCHAR(255) NOT NULL,
  `token` VARCHAR(255) NOT NULL,
  `created_at` TIMESTAMP NULL,
  PRIMARY KEY (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 3. wallets — กระเป๋าเงิน 1-to-1 กับ member
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wallets` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `balance` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `locked_balance` DECIMAL(12,2) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `wallets_user_id_unique` (`user_id`),
  CONSTRAINT `wallets_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 4. wallet_transactions — รายการเดินบัญชี
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `wallet_transactions` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `wallet_id` BIGINT UNSIGNED NOT NULL,
  `type` ENUM('topup','purchase','bid_lock','bid_refund','payout','cashback','buyback') NOT NULL,
  `amount` DECIMAL(12,2) NOT NULL,
  `ref_type` VARCHAR(40) NULL,
  `ref_id` BIGINT UNSIGNED NULL,
  `promptpay_ref` VARCHAR(60) NULL,
  `status` ENUM('pending','success','failed') NOT NULL DEFAULT 'pending',
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  INDEX `wallet_transactions_wallet_id_created_at_index` (`wallet_id`, `created_at`),
  CONSTRAINT `wallet_transactions_wallet_id_foreign`
    FOREIGN KEY (`wallet_id`) REFERENCES `wallets` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 5. addresses — ที่อยู่จัดส่ง · multiple per member
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `addresses` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` BIGINT UNSIGNED NOT NULL,
  `recipient` VARCHAR(120) NOT NULL,
  `phone` VARCHAR(20) NOT NULL,
  `line1` VARCHAR(200) NOT NULL,
  `district` VARCHAR(80) NOT NULL,
  `province` VARCHAR(80) NOT NULL,
  `postcode` VARCHAR(10) NOT NULL,
  `is_default` TINYINT(1) NOT NULL DEFAULT 0,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `addresses_user_id_foreign`
    FOREIGN KEY (`user_id`) REFERENCES `member` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 6. personal_access_tokens — Sanctum API tokens
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `personal_access_tokens` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `tokenable_type` VARCHAR(255) NOT NULL,
  `tokenable_id` BIGINT UNSIGNED NOT NULL,
  `name` TEXT NOT NULL,
  `token` VARCHAR(64) NOT NULL,
  `abilities` TEXT NULL,
  `last_used_at` TIMESTAMP NULL,
  `expires_at` TIMESTAMP NULL,
  `created_at` TIMESTAMP NULL,
  `updated_at` TIMESTAMP NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  INDEX `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`, `tokenable_id`),
  INDEX `personal_access_tokens_expires_at_index` (`expires_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ------------------------------------------------------------
-- 7. migrations — Laravel migration tracker
--    เพิ่ม record ของ migrations ที่ "ทำแล้ว" เพื่อให้ artisan migrate ไม่ run ซ้ำ
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` VARCHAR(255) NOT NULL,
  `batch` INT NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `migrations` (`migration`, `batch`) VALUES
  ('0001_01_01_000000_create_member_table', 1),
  ('2026_05_23_000001_create_wallets_addresses_table', 1),
  ('2026_05_30_062756_create_personal_access_tokens_table', 1);

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- ✅ Schema installed
-- Verify: SELECT TABLE_NAME FROM information_schema.TABLES WHERE TABLE_SCHEMA='siamcard';
-- Expected: addresses, member, migrations, password_reset_tokens,
--           personal_access_tokens, wallet_transactions, wallets
-- ============================================================
