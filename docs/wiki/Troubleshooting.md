# Troubleshooting Guide

Common issues and their solutions in Valero.

## 🚨 Common Issues

### Installation Issues

#### Permission Denied Errors

**Problem:** Getting permission errors when running commands or accessing files.

**Solution:**
```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache

# Fix ownership (replace www-data with your web server user)
sudo chown -R $USER:www-data storage bootstrap/cache
```

#### Composer Install Fails

**Problem:** `composer install` fails with memory or dependency errors.

**Solution:**
```bash
# Increase PHP memory limit
php -d memory_limit=512M /usr/local/bin/composer install

# Or update composer
composer self-update
composer clear-cache
composer install
```

#### NPM Install Fails

**Problem:** `npm install` fails or takes too long.

**Solution:**
```bash
# Clear npm cache
npm cache clean --force

# Remove node_modules and reinstall
rm -rf node_modules package-lock.json
npm install

# Or use npm ci for clean install
npm ci
```

### Database Issues

#### Migration Errors

**Problem:** Migrations fail with errors.

**Solution:**
```bash
# Check database connection
php artisan db:show

# Rollback and re-run
php artisan migrate:rollback
php artisan migrate

# If needed, fresh migration (WARNING: deletes all data)
php artisan migrate:fresh
```

#### Connection Refused

**Problem:** Can't connect to database.

**Solution:**
1. Verify database credentials in `.env`
2. Check database server is running:
   ```bash
   # MySQL
   sudo systemctl status mysql
   
   # PostgreSQL
   sudo systemctl status postgresql
   ```
3. Test connection:
   ```bash
   php artisan tinker
   DB::connection()->getPdo();
   ```

### Storage Issues

#### Images Not Showing

**Problem:** Uploaded images don't display.

**Solution:**
```bash
# Recreate storage link
rm public/storage
php artisan storage:link

# Check permissions
chmod -R 775 storage/app/public
chown -R www-data:www-data storage/app/public

# Verify files exist
ls -la storage/app/public
```

#### Storage Link Already Exists

**Problem:** `php artisan storage:link` says link already exists.

**Solution:**
```bash
# Remove existing link
rm public/storage

# Create new link
php artisan storage:link
```

#### Upload Fails

**Problem:** Can't upload images.

**Solution:**
1. Check file size limits in `php.ini`:
   ```ini
   upload_max_filesize = 10M
   post_max_size = 10M
   ```
2. Check storage permissions (see above)
3. Verify disk space:
   ```bash
   df -h
   ```

### Application Issues

#### White Screen / 500 Error

**Problem:** Getting blank page or 500 error.

**Solution:**
```bash
# Check Laravel logs
tail -f storage/logs/laravel.log

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Check permissions
chmod -R 775 storage bootstrap/cache
```

#### Route Not Found

**Problem:** 404 errors on routes.

**Solution:**
```bash
# Clear route cache
php artisan route:clear

# Rebuild route cache
php artisan route:cache

# List all routes
php artisan route:list
```

#### Config Not Updating

**Problem:** Configuration changes not taking effect.

**Solution:**
```bash
# Clear config cache
php artisan config:clear

# Rebuild config cache
php artisan config:cache
```

### Editor Issues

#### TinyMCE Not Loading

**Problem:** Rich text editor doesn't appear.

**Solution:**
1. Clear browser cache
2. Rebuild assets:
   ```bash
   npm run build
   ```
3. Check browser console for errors
4. Verify JavaScript is enabled

#### Paste Not Working

**Problem:** Can't paste content into editor.

**Solution:**
1. Check browser permissions
2. Try different paste method (Ctrl+V vs right-click)
3. Clear browser cache
4. Check browser console for errors

### Media Library Issues

#### Can't Select from Library

**Problem:** Media library modal doesn't open or images don't load.

**Solution:**
1. Check browser console for errors
2. Verify AJAX requests are working
3. Clear browser cache
4. Rebuild assets: `npm run build`

#### Images Not Attaching

**Problem:** Selected images from library don't attach to article.

**Solution:**
1. Check browser console for errors
2. Verify form submission
3. Check Laravel logs: `tail -f storage/logs/laravel.log`
4. Ensure JavaScript is enabled

### Bookmark Issues

#### Bookmarks Not Loading

**Problem:** Bookmarks don't appear in article options.

**Solution:**
1. Check browser console for errors
2. Verify AJAX endpoint is accessible
3. Check user has bookmarks
4. Clear browser cache

#### Copy to Clipboard Not Working

**Problem:** Can't copy bookmark links.

**Solution:**
1. Check if site is HTTPS (Clipboard API requires HTTPS)
2. Fallback method should work on HTTP
3. Check browser console for errors
4. Try different browser

### Performance Issues

#### Slow Page Loads

**Problem:** Pages load slowly.

**Solution:**
```bash
# Enable caching
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Optimize autoloader
composer dump-autoload --optimize

# Clear old cache
php artisan cache:clear
```

#### High Memory Usage

**Problem:** Application uses too much memory.

**Solution:**
1. Increase PHP memory limit in `php.ini`:
   ```ini
   memory_limit = 256M
   ```
2. Optimize images before uploading
3. Use queue workers for heavy tasks
4. Enable OPcache

### Browser-Specific Issues

#### Dark Mode Not Working

**Problem:** Dark mode toggle doesn't work.

**Solution:**
1. Clear browser cache
2. Check localStorage is enabled
3. Verify JavaScript is working
4. Try different browser

#### Styles Not Loading

**Problem:** CSS not applying correctly.

**Solution:**
```bash
# Rebuild assets
npm run build

# Clear browser cache
# Hard refresh: Ctrl+Shift+R (Windows) or Cmd+Shift+R (Mac)
```

## 🔍 Debugging

### Enable Debug Mode

**Development only!** In `.env`:
```env
APP_DEBUG=true
```

### Check Logs

```bash
# View Laravel logs
tail -f storage/logs/laravel.log

# View specific log level
tail -f storage/logs/laravel.log | grep ERROR
```

### Database Queries

Enable query logging in `.env`:
```env
DB_LOG_QUERIES=true
```

### Browser Console

1. Open browser DevTools (F12)
2. Check Console tab for errors
3. Check Network tab for failed requests
4. Check Application tab for storage issues

## 🛠️ Maintenance Commands

### Clear All Caches

```bash
php artisan optimize:clear
```

### Rebuild Everything

```bash
# Clear caches
php artisan optimize:clear

# Rebuild assets
npm run build

# Rebuild configs
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### Check System Health

```bash
# Check PHP version
php -v

# Check Composer
composer --version

# Check Node
node -v
npm -v

# Check database connection
php artisan db:show

# Check storage link
ls -la public/storage
```

## 📞 Getting Help

### Before Asking for Help

1. ✅ Check this troubleshooting guide
2. ✅ Check the [FAQ](FAQ)
3. ✅ Search [GitHub Issues](https://github.com/zmeuldev/valero/issues)
4. ✅ Check Laravel logs
5. ✅ Check browser console

### When Reporting Issues

Include:
- PHP version
- Laravel version
- Error messages
- Steps to reproduce
- Browser/OS information
- Relevant log entries

### Useful Commands

```bash
# System information
php artisan about

# List all routes
php artisan route:list

# Check environment
php artisan env

# Test database connection
php artisan tinker
DB::connection()->getPdo();
```

---

**Still stuck?** [Open an issue](https://github.com/zmeuldev/valero/issues) with detailed information.

