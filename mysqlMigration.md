# MySQL Migration

## Step 1: Drop the `featured_image` column
```sql
ALTER TABLE `citybrk_comdb`.`articles`
DROP COLUMN `featured_image`;
```

## Step 2: Add the `is_featured` column
```sql
ALTER TABLE `citybrk_comdb`.`articles`
ADD COLUMN `is_featured` BOOLEAN DEFAULT FALSE AFTER `views`;
```

## Step 3: Rename table images to media
```sql
RENAME TABLE `citybrk_comdb`.`images` TO `citybrk_comdb`.`media`;
```

## Step 4: Update the `media` table
```sql
ALTER TABLE `citybrk_comdb`.`media`
ADD COLUMN `is_cover` BOOLEAN DEFAULT FALSE AFTER `article_id`,
ADD COLUMN `alt_text` VARCHAR(255) NULL AFTER `image_path`,
ADD COLUMN `caption` VARCHAR(255) NULL AFTER `alt_text`,
ADD COLUMN `type` VARCHAR(255) NULL AFTER `caption`,
ADD COLUMN `mime_type` VARCHAR(255) NULL AFTER `type`,
ADD COLUMN `size` VARCHAR(255) NULL AFTER `mime_type`,
ADD COLUMN `dimensions` VARCHAR(255) NULL AFTER `size`,
ADD COLUMN `filename` VARCHAR(255) NULL AFTER `dimensions`;
```

## Step 5: Set is_cover
```sql
update media set is_cover=1 where id in (article_id);
```


