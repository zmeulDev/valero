# First Steps

Get started with Valero in just a few minutes!

## ✅ After Installation

Once you've installed Valero, follow these steps:

### 1. Create Admin User

If you didn't use the seeder, create an admin user:

```sql
UPDATE users SET role='admin', email_verified_at=NOW() WHERE id = 1;
```

Or register a new user and update the role in the database.

### 2. Log In

1. Visit your site URL
2. Click **Login**
3. Enter your admin credentials
4. You'll be redirected to the admin dashboard

### 3. Configure Basic Settings

Go to **Admin → Settings** and configure:

#### Brand Settings
- Upload your logo
- Upload favicon
- Set site name
- Add tagline

#### SEO Settings
- Set site title
- Add meta description
- Add keywords
- Upload OG image

#### Social Media
- Add your social media URLs
- Facebook, Twitter, Instagram, YouTube, LinkedIn

### 4. Create Your First Category

1. Go to **Categories**
2. Click **New Category**
3. Enter category name
4. Add description (optional)
5. Click **Save**

### 5. Create Your First Article

1. Go to **Articles → Create New**
2. Fill in:
   - **Title** - Your article title
   - **Content** - Write your article
   - **Category** - Select category
   - **Publish Date** - Choose date
3. Upload a cover image (optional)
4. Add images to gallery (optional)
5. Configure SEO settings (optional)
6. Click **Create Article**

### 6. Create Your First Bookmark

1. Go to **Bookmarks**
2. Click **New Bookmark**
3. Fill in:
   - **Title** - Bookmark name
   - **Link** - URL (optional)
   - **Notes** - Additional info (optional)
   - **Category** - Organize (optional)
4. Click **Save Bookmark**

## 🎯 Quick Wins

### Set Up Your Profile

1. Go to **Profile**
2. Upload profile photo
3. Update bio
4. Enable 2FA (recommended)

### Customize Appearance

1. Go to **Settings → Brand**
2. Upload logo and favicon
3. Customize colors in `tailwind.config.js` (advanced)

### Enable Caching

For better performance:

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📚 Next Steps

Now that you're set up:

1. **[User Guide](User-Guide)** - Learn how to use Valero
2. **[Admin Guide](Admin-Guide)** - Master administration
3. **[Features](Features)** - Discover all features
4. **[Configuration](Configuration)** - Advanced configuration

## 💡 Tips

- **Start Simple** - Create a few articles first
- **Use Categories** - Organize from the beginning
- **Save Bookmarks** - Store reusable links
- **Test Features** - Try scheduled articles, previews, etc.
- **Read Documentation** - Check guides for advanced features

## 🆘 Need Help?

- Check the [FAQ](FAQ)
- Read [Troubleshooting](Troubleshooting)
- [Open an issue](https://github.com/zmeuldev/valero/issues)

---

**Ready to go!** Start creating amazing content with Valero! 🚀

