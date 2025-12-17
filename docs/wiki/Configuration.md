# Configuration Guide

This guide covers all configuration options available in Valero.

## 📁 Environment Variables

The main configuration file is `.env` in the project root. Here are the key settings:

### Application Settings

```env
APP_NAME="Valero"
APP_ENV=local
APP_KEY=base64:...
APP_DEBUG=true
APP_TIMEZONE=UTC
APP_URL=http://localhost
APP_LOCALE=en
APP_FALLBACK_LOCALE=en
```

### Database Configuration

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=valero
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### Mail Configuration

```env
MAIL_MAILER=smtp
MAIL_HOST=your-smtp-host
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="noreply@yourapp.com"
MAIL_FROM_NAME="${APP_NAME}"
```

### File Storage

```env
FILESYSTEM_DISK=local
# For cloud storage (S3, etc.)
# AWS_ACCESS_KEY_ID=
# AWS_SECRET_ACCESS_KEY=
# AWS_DEFAULT_REGION=
# AWS_BUCKET=
```

### Session & Cache

```env
SESSION_DRIVER=file
SESSION_LIFETIME=120
CACHE_DRIVER=file
QUEUE_CONNECTION=sync
```

## ⚙️ Admin Panel Settings

Access admin settings at `/admin/settings` to configure:

### SEO Settings

- **Site Title** - Main site title
- **Meta Description** - Default meta description
- **Keywords** - Default keywords
- **OG Image** - Default Open Graph image
- **Twitter Card** - Twitter card settings

### Brand Settings

- **Logo** - Upload your logo
- **Favicon** - Upload favicon
- **Site Name** - Display name
- **Tagline** - Site tagline

### Social Media

- **Facebook URL**
- **Twitter URL**
- **Instagram URL**
- **YouTube URL**
- **LinkedIn URL**

### API Keys

- **Google Analytics** - Tracking ID
- **Google Search Console** - Verification code
- **Facebook Pixel** - Pixel ID
- **Other services** - As needed

## 🎨 Customization

### Changing Themes

Valero uses Tailwind CSS. Customize colors in `tailwind.config.js`:

```javascript
module.exports = {
  theme: {
    extend: {
      colors: {
        primary: {
          // Your custom colors
        }
      }
    }
  }
}
```

### Language Configuration

Supported languages:
- English (`en`)
- Romanian (`ro`)
- Spanish (`es`)

To add a new language:

1. Create language files in `resources/lang/{locale}/`
2. Update `config/app.php` available locales
3. Add language selector to your views

### Timezone Configuration

Set your timezone in `.env`:

```env
APP_TIMEZONE=America/New_York
```

## 📊 Performance Settings

### Caching

Enable caching for production:

```env
CACHE_DRIVER=redis
# or
CACHE_DRIVER=memcached
```

### Queue Configuration

For better performance, use queue workers:

```env
QUEUE_CONNECTION=database
# or
QUEUE_CONNECTION=redis
```

Then run queue workers:

```bash
php artisan queue:work
```

### Image Optimization

Configure image handling in `config/filesystems.php`:

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => storage_path('app/public'),
        'url' => env('APP_URL').'/storage',
        'visibility' => 'public',
    ],
],
```

## 🔒 Security Settings

### HTTPS Configuration

For production, ensure HTTPS:

```env
APP_URL=https://yourdomain.com
```

Force HTTPS in `app/Providers/AppServiceProvider.php`:

```php
if (config('app.env') === 'production') {
    URL::forceScheme('https');
}
```

### Session Security

```env
SESSION_SECURE_COOKIE=true
SESSION_HTTP_ONLY=true
SESSION_SAME_SITE=lax
```

## 📧 Email Templates

Customize email templates in `resources/views/emails/`. Templates support:

- HTML formatting
- Dark mode variants
- Brand colors
- Custom styling

## 🗄️ Database Settings

### Connection Pooling

For high-traffic sites, configure connection pooling:

```env
DB_POOL_SIZE=10
```

### Query Logging

Enable query logging for debugging:

```env
DB_LOG_QUERIES=true
```

## 🔍 Search Configuration

Configure search settings in `config/scout.php` (if using Laravel Scout):

```php
'driver' => env('SCOUT_DRIVER', 'database'),
```

## 📝 Logging

Configure logging in `config/logging.php`:

```php
'channels' => [
    'daily' => [
        'driver' => 'daily',
        'path' => storage_path('logs/laravel.log'),
        'level' => env('LOG_LEVEL', 'debug'),
        'days' => 14,
    ],
],
```

## ✅ Configuration Checklist

- [ ] Database credentials configured
- [ ] Mail settings configured
- [ ] Storage link created
- [ ] Admin user created
- [ ] SEO settings configured
- [ ] Brand assets uploaded
- [ ] Social media links added
- [ ] API keys configured (if needed)
- [ ] Timezone set correctly
- [ ] HTTPS configured (production)
- [ ] Caching enabled (production)

## 🔄 After Configuration Changes

After making configuration changes:

```bash
php artisan config:clear
php artisan config:cache
php artisan cache:clear
```

## 📚 Related Documentation

- [Installation Guide](Installation)
- [Performance Optimization](Performance-Optimization)
- [Troubleshooting](Troubleshooting)

---

**Need Help?** Check the [FAQ](FAQ) or [open an issue](https://github.com/zmeuldev/valero/issues).

