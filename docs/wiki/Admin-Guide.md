# Admin Guide

This guide covers advanced administration features in Valero.

## 🔐 Admin Access

### Admin Requirements

- User account with `admin` role
- Email verified
- Authenticated session

### Admin Panel Access

Navigate to `/admin` to access the admin panel.

## 📊 Dashboard

### Overview Statistics

The dashboard displays:
- **Total Articles** - All articles count
- **Published Articles** - Live articles
- **Draft Articles** - Unpublished articles
- **Scheduled Articles** - Future publications
- **Categories** - Total categories
- **Media Files** - Total images
- **Bookmarks** - Total bookmarks

### Quick Actions

- Create new article
- View all articles
- Access media library
- Manage bookmarks
- View settings

## 📝 Article Management

### Article List

View and manage all articles:
- **Search** - Search by title or content
- **Filter** - Filter by status (published/draft/scheduled)
- **Sort** - Sort by date, title, or category
- **Bulk Actions** - Select multiple articles

### Article Actions

- **View** - Preview article
- **Edit** - Modify article
- **Delete** - Remove article (with confirmation)
- **Duplicate** - Create copy (if implemented)

### Scheduled Articles
 
Access via **Articles → Scheduled**:
- **Comprehensive Dashboard**:
  - **Calendar Widget**: Interactive monthly view of scheduled content
  - **List View**: Paginated table with cover images and status
- **Search & Filter**:
  - Search by article title
  - Filter by category (updates both list and calendar)
- **Management**:
  - Click any article to direct edit
  - Quick preview access
 
### Article Preview
 
Preview scheduled articles:
1. Go to scheduled articles
2. Click **Preview** icon
3. **Device Toggle**: Switch between Desktop, Tablet, and Mobile views to verify responsiveness
4. **Gallery Inspection**: Click images to open the enhanced gallery modal (Zoom, Fullscreen)
5. **Status Verification**: Check "Scheduled" badge and publication date
6. Edit if needed directly from the header action

## 📚 Playlist Management

### Creating Playlists

1. Navigate to **Playlists** in the sidebar
2. Click **New Playlist**
3. Enter:
   - **Title** - Name of the series (e.g., "Laravel for Beginners")
   - **Description** - Overview of what the collection covers

### Managing Articles in Playlists

The playlist editor features a dual-list interface:
- **Left Panel**: Available articles (searchable)
- **Right Panel**: Playlist sequence

**To add articles:**
1. Search for an article in the left panel
2. Click to add it to the sequence

**To reorder:**
- Use the **Up/Down arrows** to change the reading order
- This order determines the "Next/Previous" navigation on the frontend

## 🗂️ Category Management

### Creating Categories

1. Go to **Categories**
2. Click **New Category**
3. Enter:
   - **Name** - Category name
   - **Slug** - URL-friendly name (auto-generated)
   - **Description** - Category description
4. Click **Save**

### Managing Categories

- **Edit** - Update category details
- **Delete** - Remove category (articles remain)
- **View Articles** - See articles in category

## 🖼️ Media Library

### Media Overview

View all uploaded media:
- **Grid View** - Visual grid of images
- **List View** - Detailed list
- **Search** - Find specific images
- **Filter** - Filter by article

### Media Actions

- **View** - Open in modal gallery
- **Set Cover** - Designate as cover image
- **Delete** - Remove image (if not shared)
- **View Details** - See metadata

### Media Library Features

#### Reusing Images

When creating/editing articles:
1. Click **Select from Media Library**
2. Browse existing images
3. Search or filter
4. Select images to reuse
5. Images are attached to the article

#### Reference Counting

- Images shared across articles are preserved
- Deleting an article doesn't delete shared images
- Only truly orphaned images can be deleted
- Use `php artisan media:cleanup-orphaned` to find orphaned files

## 🔖 Bookmark Management

### Bookmark Overview

View all bookmarks:
- **Card Grid** - Modern card layout
- **Search** - Search across all fields
- **Category Filters** - Filter by category
- **Pagination** - 10 items per page

### Creating Bookmarks

1. Go to **Bookmarks**
2. Click **New Bookmark**
3. Fill in:
   - **Title** - Bookmark name
   - **Link** - URL (optional)
   - **Notes** - Additional information
   - **Category** - Select or create new
4. Click **Save**

### Managing Bookmarks

- **Edit** - Update bookmark
- **Delete** - Remove bookmark
- **Copy Link** - Quick copy to clipboard
- **Filter** - Filter by category

### Bookmark Categories

- Create categories on-the-fly
- Organize bookmarks efficiently
- Filter by category
- Case-sensitive category names

## ⚙️ Settings Management

### SEO Settings

Configure at **Settings → SEO**:
- **Site Title** - Main site title
- **Meta Description** - Default description
- **Keywords** - Default keywords
- **OG Image** - Default Open Graph image
- **Twitter Card** - Twitter settings

### Brand Settings

Configure at **Settings → Brand**:
- **Logo** - Upload site logo
- **Favicon** - Upload favicon
- **Site Name** - Display name
- **Tagline** - Site tagline

### Social Media

Configure at **Settings → Social**:
- **Facebook URL**
- **Twitter URL**
- **Instagram URL**
- **YouTube URL**
- **LinkedIn URL**

### API Keys

Configure at **Settings → API**:
- **Google Analytics** - Tracking ID
- **Google Search Console** - Verification code
- **Facebook Pixel** - Pixel ID
- **Other Services** - As needed

## 👥 User Management

### Viewing Users

- See all registered users
- View user details
- Check user roles
- View activity

### User Roles

- **Admin** - Full access
- **User** - Limited access

### Managing Users

- **Edit** - Update user details
- **Delete** - Remove user (with caution)
- **Change Role** - Promote/demote users

## 🔧 Maintenance

### Cache Management

Clear caches:
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
```

Cache for production:
```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### Image Cleanup

Find orphaned images:
```bash
php artisan media:cleanup-orphaned --dry-run
```

Delete orphaned images:
```bash
php artisan media:cleanup-orphaned --force
```

### Database Maintenance

Optimize database:
```bash
php artisan migrate:fresh --seed  # Development only!
```

## 📈 Analytics & Reports

### Article Statistics

- Total articles
- Published count
- Draft count
- Scheduled count
- By category breakdown

### Media Statistics

- Total images
- Total storage used
- Images per article average
- Most used images

### User Statistics

- Total users
- Active users
- Admin users
- Recent registrations

## 🔒 Security Best Practices

### Admin Security

1. **Strong Passwords** - Use complex passwords
2. **2FA** - Enable two-factor authentication
3. **Regular Updates** - Keep Valero updated
4. **Backup** - Regular database backups
5. **HTTPS** - Use HTTPS in production

### Access Control

- Limit admin accounts
- Review user roles regularly
- Monitor user activity
- Remove inactive accounts

## 🎨 Customization

### Theme Customization

Edit `tailwind.config.js` for colors:
```javascript
theme: {
  extend: {
    colors: {
      primary: {
        // Your colors
      }
    }
  }
}
```

### Language Customization

Add languages in `resources/lang/`:
1. Create language directory
2. Copy existing language files
3. Translate strings
4. Update `config/app.php`

## 📊 Performance Optimization

### Caching

Enable caching:
- Config cache
- Route cache
- View cache
- Query cache

### Database Optimization

- Add indexes
- Optimize queries
- Regular maintenance
- Connection pooling

### Asset Optimization

- Minify CSS/JS
- Compress images
- Use CDN
- Enable gzip

## 🆘 Troubleshooting

### Common Admin Issues

**Can't access admin panel:**
- Check user role is `admin`
- Verify email is verified
- Clear browser cache

**Images not uploading:**
- Check file permissions
- Verify storage link
- Check file size limits

**Settings not saving:**
- Check form validation
- Verify database connection
- Clear config cache

## 📚 Advanced Features

### API Access

- API token management
- Generate tokens
- Revoke tokens
- Token permissions

### Webhooks

- Configure webhooks
- Event triggers
- Payload customization

### Integrations

- Third-party services
- Custom integrations
- API endpoints

---

**Need more help?** Check the [Developer Guide](Developer-Guide) or [Troubleshooting](Troubleshooting) page.

