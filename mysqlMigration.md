# MySQL Migration

## Step 1: Drop the `featured_image` column
```sql
ALTER TABLE `laravel`.`articles`
DROP COLUMN `featured_image`;
```

## Step 2: Add the `is_featured` column
```sql
ALTER TABLE `laravel`.`articles`
ADD COLUMN `is_featured` BOOLEAN DEFAULT FALSE AFTER `views`;
```

## Step 3: Rename table images to media
```sql
RENAME TABLE `laravel`.`images` TO `laravel`.`media`;
```

## Step 4: Update the `media` table
```sql
ALTER TABLE `laravel`.`media`
ADD COLUMN `is_cover` BOOLEAN DEFAULT FALSE AFTER `article_id`,
ADD COLUMN `alt_text` VARCHAR(255) NULL AFTER `image_path`,
ADD COLUMN `caption` VARCHAR(255) NULL AFTER `alt_text`,
ADD COLUMN `type` VARCHAR(255) NULL AFTER `caption`,
ADD COLUMN `mime_type` VARCHAR(255) NULL AFTER `type`,
ADD COLUMN `size` VARCHAR(255) NULL AFTER `mime_type`;
```

