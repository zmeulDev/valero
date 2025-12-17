# Frequently Asked Questions (FAQ)

Common questions and answers about Valero.

## 🚀 Installation & Setup

### Q: What are the system requirements?

**A:** Valero requires:
- PHP 8.2 or higher
- Composer 2.0 or higher
- Node.js 18.x or higher
- MySQL 8.0+ or PostgreSQL 13+
- 512MB+ RAM (1GB+ recommended)
- 100MB+ disk space (more for media)

### Q: How do I install Valero?

**A:** See the [Installation Guide](Installation) for detailed steps. Quick version:
```bash
git clone https://github.com/zmeuldev/valero.git
cd valero
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan storage:link
npm run build
```

### Q: I'm getting permission errors. How do I fix them?

**A:** Fix storage permissions:
```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```
(Replace `www-data` with your web server user)

### Q: The storage link isn't working. What should I do?

**A:** Remove and recreate the link:
```bash
rm public/storage
php artisan storage:link
```

## 📝 Articles

### Q: How many images can I upload per article?

**A:** You can upload up to 30 images per article. Each image can be up to 5120x5120px.

### Q: Can I reuse images from other articles?

**A:** Yes! When creating or editing an article, click "Select from Media Library" to reuse existing images.

### Q: What happens if I delete an article with images?

**A:** If an image is only used by that article, it will be deleted. If the image is shared with other articles, it will be preserved.

### Q: How do I schedule an article?

**A:** Set a future date in the "Publish Date" field when creating or editing an article. The article will be scheduled automatically.

### Q: Can I preview scheduled articles?

**A:** Yes! Go to Articles → Scheduled and click Preview. You can also toggle between desktop/tablet/mobile views.

### Q: What's the maximum article length?

**A:** There's no hard limit, but for best performance, keep articles under 50,000 words.

## 🖼️ Media

### Q: What image formats are supported?

**A:** Valero supports JPEG, PNG, GIF, and WebP formats.

### Q: Are images optimized automatically?

**A:** Images are stored as-is to preserve quality. You should optimize images before uploading for best performance.

### Q: How do I find orphaned images?

**A:** Run:
```bash
php artisan media:cleanup-orphaned --dry-run
```
This shows images without database records. Use `--force` to delete them.

### Q: Can I bulk upload images?

**A:** Yes! You can upload up to 30 images at once using drag-and-drop or the file picker.

## 🔖 Bookmarks

### Q: What are bookmarks used for?

**A:** Bookmarks let you store reusable links, notes, and information that you frequently use in articles. Perfect for partner links, research notes, or reference materials.

### Q: Can I organize bookmarks?

**A:** Yes! You can create categories and filter bookmarks by category.

### Q: How do I copy a bookmark link?

**A:** Click the "Copy Link" button on any bookmark. The link will be copied to your clipboard with visual confirmation.

### Q: Are bookmarks shared between users?

**A:** No, bookmarks are user-specific. Each admin user has their own bookmarks.

## ⚙️ Configuration

### Q: How do I change the site name?

**A:** Go to Admin → Settings → Brand and update the "Site Name" field.

### Q: How do I add my logo?

**A:** Go to Admin → Settings → Brand and upload your logo in the "Logo" field.

### Q: Can I customize colors?

**A:** Yes! Edit `tailwind.config.js` to customize the color scheme.

### Q: How do I add a new language?

**A:** 
1. Create language files in `resources/lang/{locale}/`
2. Copy existing language files and translate
3. Update `config/app.php` to include the new locale

## 🔒 Security

### Q: How do I enable HTTPS?

**A:** 
1. Set `APP_URL=https://yourdomain.com` in `.env`
2. Configure your web server for SSL
3. Force HTTPS in production (see Configuration guide)

### Q: Should I use 2FA?

**A:** Yes! Two-factor authentication adds an extra layer of security. Enable it in Profile → Security.

### Q: How do I backup my data?

**A:** 
1. Backup your database regularly
2. Backup the `storage/app/public` directory
3. Consider automated backups

## 🎨 Customization

### Q: Can I change the theme?

**A:** Valero uses Tailwind CSS. You can customize colors, fonts, and styles in `tailwind.config.js`.

### Q: Can I add custom pages?

**A:** Yes! Create new routes in `routes/web.php` and corresponding views.

### Q: How do I add custom fields to articles?

**A:** 
1. Create a migration to add the field
2. Update the Article model
3. Add the field to create/edit forms
4. Update the display views

## 🐛 Troubleshooting

### Q: Images aren't showing. What's wrong?

**A:** 
1. Check that `php artisan storage:link` was run
2. Verify file permissions
3. Check that images exist in `storage/app/public`
4. Clear browser cache

### Q: The editor isn't working. How do I fix it?

**A:** 
1. Clear browser cache
2. Run `npm run build`
3. Check browser console for errors
4. Ensure JavaScript is enabled

### Q: I'm getting database errors. What should I do?

**A:** 
1. Verify database credentials in `.env`
2. Check database server is running
3. Ensure database exists
4. Run `php artisan migrate` to ensure tables exist

### Q: The site is slow. How can I improve performance?

**A:** 
1. Enable caching: `php artisan config:cache`
2. Optimize images before uploading
3. Use a CDN for assets
4. Enable database query caching
5. Use queue workers for background tasks

## 📊 Performance

### Q: How many articles can Valero handle?

**A:** Valero can handle thousands of articles. Performance depends on:
- Server resources
- Database optimization
- Image optimization
- Caching configuration

### Q: Should I use Redis for caching?

**A:** Redis is recommended for production. It's faster than file-based caching and supports more features.

### Q: How do I optimize database queries?

**A:** 
1. Add indexes to frequently queried columns
2. Use eager loading (`with()`) to prevent N+1 queries
3. Enable query caching
4. Use database connection pooling

## 🔄 Updates

### Q: How do I update Valero?

**A:** 
1. Backup your database and files
2. Pull latest changes: `git pull`
3. Update dependencies: `composer install && npm install`
4. Run migrations: `php artisan migrate`
5. Rebuild assets: `npm run build`
6. Clear caches: `php artisan optimize`

### Q: Will updates break my customizations?

**A:** It depends. Always:
1. Test updates in a staging environment
2. Keep customizations in separate files when possible
3. Document your customizations
4. Backup before updating

## 💬 Support

### Q: Where can I get help?

**A:** 
- Check this FAQ
- Read the [Troubleshooting](Troubleshooting) guide
- Search [GitHub Issues](https://github.com/zmeuldev/valero/issues)
- Open a new issue if needed

### Q: How do I report a bug?

**A:** Use the [Bug Report template](https://github.com/zmeuldev/valero/issues/new?template=bug_report.yml) on GitHub.

### Q: Can I request a feature?

**A:** Yes! Use the [Feature Request template](https://github.com/zmeuldev/valero/issues/new?template=feature_request.yml) on GitHub.

---

**Still have questions?** Check the [Troubleshooting](Troubleshooting) guide or [open an issue](https://github.com/zmeuldev/valero/issues).

