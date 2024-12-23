CREATE TABLE `articles` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`user_id` BIGINT unsigned NOT NULL
	,`category_id` BIGINT unsigned NOT NULL
	,`title` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`slug` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`tags` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`excerpt` TEXT COLLATE utf8mb4_unicode_ci
	,`content` longtext COLLATE utf8mb4_unicode_ci NOT NULL
	,`featured_image` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`views` BIGINT unsigned NOT NULL DEFAULT '0'
	,`likes_count` BIGINT unsigned NOT NULL DEFAULT '0'
	,`scheduled_at` TIMESTAMP NULL DEFAULT NULL
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,`updated_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`id`)
	,UNIQUE KEY `articles_slug_unique`(`slug`)
	,KEY `articles_user_id_foreign`(`user_id`)
	,KEY `articles_category_id_foreign`(`category_id`)
	,CONSTRAINT `articles_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories`(`id`) ON DELETE CASCADE
	,CONSTRAINT `articles_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `users`(`id`) ON DELETE CASCADE
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `cache` (
	`key` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`value` mediumtext COLLATE utf8mb4_unicode_ci NOT NULL
	,`expiration` INT NOT NULL
	,PRIMARY KEY (`key`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `cache_locks` (
	`key` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`owner` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`expiration` INT NOT NULL
	,PRIMARY KEY (`key`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `categories` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`slug` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,`updated_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`id`)
	,UNIQUE KEY `categories_name_unique`(`name`)
	,UNIQUE KEY `categories_slug_unique`(`slug`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `failed_jobs` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`uuid` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`connection` TEXT COLLATE utf8mb4_unicode_ci NOT NULL
	,`queue` TEXT COLLATE utf8mb4_unicode_ci NOT NULL
	,`payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL
	,`exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL
	,`failed_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
	,PRIMARY KEY (`id`)
	,UNIQUE KEY `failed_jobs_uuid_unique`(`uuid`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `images` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`article_id` BIGINT unsigned NOT NULL
	,`image_path` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,`updated_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`id`)
	,KEY `images_article_id_foreign`(`article_id`)
	,CONSTRAINT `images_article_id_foreign` FOREIGN KEY (`article_id`) REFERENCES `articles`(`id`) ON DELETE CASCADE
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `job_batches` (
	`id` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`total_jobs` INT NOT NULL
	,`pending_jobs` INT NOT NULL
	,`failed_jobs` INT NOT NULL
	,`failed_job_ids` longtext COLLATE utf8mb4_unicode_ci NOT NULL
	,`options` mediumtext COLLATE utf8mb4_unicode_ci
	,`cancelled_at` INT DEFAULT NULL
	,`created_at` INT NOT NULL
	,`finished_at` INT DEFAULT NULL
	,PRIMARY KEY (`id`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `jobs` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`queue` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL
	,`attempts` TINYINT unsigned NOT NULL
	,`reserved_at` INT unsigned DEFAULT NULL
	,`available_at` INT unsigned NOT NULL
	,`created_at` INT unsigned NOT NULL
	,PRIMARY KEY (`id`)
	,KEY `jobs_queue_index`(`queue`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `migrations` (
	`id` INT unsigned NOT NULL AUTO_INCREMENT
	,`migration` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`batch` INT NOT NULL
	,PRIMARY KEY (`id`)
	) ENGINE = InnoDB AUTO_INCREMENT = 11 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `partners` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`link` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`image` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`text` TEXT COLLATE utf8mb4_unicode_ci
	,`position` enum('sidebar', 'header', 'footer') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'sidebar'
	,`start_date` DATE DEFAULT NULL
	,`expiration_date` DATE DEFAULT NULL
	,`seo` json DEFAULT NULL
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,`updated_at` TIMESTAMP NULL DEFAULT NULL
	,`deleted_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`id`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `password_reset_tokens` (
	`email` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`token` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`email`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `personal_access_tokens` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`tokenable_type` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`tokenable_id` BIGINT unsigned NOT NULL
	,`name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`token` VARCHAR(64) COLLATE utf8mb4_unicode_ci NOT NULL
	,`abilities` TEXT COLLATE utf8mb4_unicode_ci
	,`last_used_at` TIMESTAMP NULL DEFAULT NULL
	,`expires_at` TIMESTAMP NULL DEFAULT NULL
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,`updated_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`id`)
	,UNIQUE KEY `personal_access_tokens_token_unique`(`token`)
	,KEY `personal_access_tokens_tokenable_type_tokenable_id_index`(`tokenable_type`, `tokenable_id`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `seo` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`model_type` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`model_id` BIGINT unsigned NOT NULL
	,`description` longtext COLLATE utf8mb4_unicode_ci
	,`title` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`tags` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`image` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`author` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`robots` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`canonical_url` VARCHAR(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,`updated_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`id`)
	,KEY `seo_model_type_model_id_index`(`model_type`, `model_id`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `sessions` (
	`id` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`user_id` BIGINT unsigned DEFAULT NULL
	,`ip_address` VARCHAR(45) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`user_agent` TEXT COLLATE utf8mb4_unicode_ci
	,`payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL
	,`last_activity` INT NOT NULL
	,PRIMARY KEY (`id`)
	,KEY `sessions_user_id_index`(`user_id`)
	,KEY `sessions_last_activity_index`(`last_activity`)
	) ENGINE = InnoDB DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `settings` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`key` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`value` TEXT COLLATE utf8mb4_unicode_ci
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,`updated_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`id`)
	,UNIQUE KEY `settings_key_unique`(`key`)
	) ENGINE = InnoDB AUTO_INCREMENT = 13 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;

CREATE TABLE `users` (
	`id` BIGINT unsigned NOT NULL AUTO_INCREMENT
	,`name` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`email` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`password` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL
	,`role` VARCHAR(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'user'
	,`is_active` TINYINT (1) NOT NULL DEFAULT '1'
	,`email_verified_at` TIMESTAMP NULL DEFAULT NULL
	,`two_factor_secret` TEXT COLLATE utf8mb4_unicode_ci
	,`two_factor_recovery_codes` TEXT COLLATE utf8mb4_unicode_ci
	,`two_factor_confirmed_at` TIMESTAMP NULL DEFAULT NULL
	,`remember_token` VARCHAR(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`profile_photo_path` VARCHAR(2048) COLLATE utf8mb4_unicode_ci DEFAULT NULL
	,`last_login_at` TIMESTAMP NULL DEFAULT NULL
	,`created_at` TIMESTAMP NULL DEFAULT NULL
	,`updated_at` TIMESTAMP NULL DEFAULT NULL
	,PRIMARY KEY (`id`)
	,UNIQUE KEY `users_email_unique`(`email`)
	) ENGINE = InnoDB AUTO_INCREMENT = 2 DEFAULT CHARSET = utf8mb4 COLLATE = utf8mb4_unicode_ci;