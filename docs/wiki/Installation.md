# Installation Guide

This guide will walk you through installing Valero on your system.

## 📋 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP** 8.2 or higher
- **Composer** 2.0 or higher
- **Node.js** 18.x or higher and **NPM**
- **MySQL** 8.0+ or **PostgreSQL** 13+
- **Git**

### Verify Prerequisites

```bash
php -v          # Should show PHP 8.2+
composer -V     # Should show Composer 2.0+
node -v         # Should show Node.js 18+
npm -v          # Should show NPM 9+
mysql --version # Should show MySQL 8.0+
```

## 🚀 Installation Steps

### 1. Clone the Repository

```bash
git clone https://github.com/zmeuldev/valero.git
cd valero
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Environment Configuration

Copy the example environment file:

```bash
cp .env.example .env
```

Generate the application key:

```bash
php artisan key:generate
```

### 5. Configure Database

Edit `.env` and set your database credentials:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=valero
DB_USERNAME=your_username
DB_PASSWORD=your_password
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Create Storage Link

Link the storage directory for uploaded files:

```bash
php artisan storage:link
```

### 8. Seed Database (Optional)

For demo purposes, you can seed the database:

```bash
php artisan db:seed
php artisan db:seed --class=DemoSeeder
```

**Default credentials:**
- Email: `admin@example.com`
- Password: `password`

> **Note:** If you're not using the seeder, manually update at least one user in the database:
> ```sql
> UPDATE users SET role='admin', email_verified_at=NOW() WHERE id = 1;
> ```

### 9. Compile Assets

**For Development:**
```bash
npm run dev
```

**For Production:**
```bash
npm run build
```

### 10. Start the Server

**Development:**
```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

**Production:**
Configure your web server (Nginx/Apache) to point to the `public` directory.

## 🔧 Post-Installation

### Clear Caches

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### Optimize for Production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

## 🐳 Docker Installation (Optional)

If you prefer Docker, you can use Laravel Sail:

```bash
# Install Sail
composer require laravel/sail --dev

# Publish Sail configuration
php artisan sail:install

# Start containers
./vendor/bin/sail up -d

# Run migrations
./vendor/bin/sail artisan migrate
```

## ✅ Verification

After installation, verify everything is working:

1. Visit your site URL
2. Register a new user or login with seeded credentials
3. Access the admin panel at `/admin`
4. Create a test article

## 🆘 Troubleshooting

### Permission Issues

If you encounter permission issues:

```bash
# Fix storage permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### Database Connection Errors

- Verify database credentials in `.env`
- Ensure the database exists
- Check database server is running

### Asset Compilation Errors

- Clear node_modules: `rm -rf node_modules && npm install`
- Clear npm cache: `npm cache clean --force`
- Try using `npm ci` instead of `npm install`

### Storage Link Issues

If `php artisan storage:link` fails:

```bash
# Remove existing link
rm public/storage

# Create new link
php artisan storage:link
```

## 📚 Next Steps

- [Configuration Guide](Configuration)
- [First Steps](First-Steps)
- [User Guide](User-Guide)

---

**Need Help?** Check the [Troubleshooting](Troubleshooting) page or [open an issue](https://github.com/zmeuldev/valero/issues).

