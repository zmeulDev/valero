# Valero - Blogging Platform

Valero is an open-source article-sharing platform built with **Laravel 11** and **Livewire**. It features a modern, responsive design with advanced media management and article organization capabilities.

## 📦 Core Features

### Article Management
- Full CRUD operations for articles
- Rich text editor with smart paste handling (preserves lists and formatting)
- Cover image designation with validation
- Multiple image galleries per article (up to 5120x5120px)
- Automatic reading time calculation
- Related articles functionality (modern compact design)
- **Dynamic SEO management** (configurable meta tags, OG tags, keywords)
- Article scheduling and drafts
- Category organization
- **Article preview system for scheduled content**
- **Scheduled articles calendar view**
- Social media link integration (YouTube, Instagram, Local Store)

### Media Management
- Dedicated media library with enhanced grid view
- **Color profile preservation** (ICC profiles maintained)
- Image metadata tracking:
  - Dimensions (up to 5120x5120px)
  - File size with accurate MB/KB display
  - Upload date
  - Article association
  - Alt text for accessibility
- Cover image designation with AJAX updates
- **Enhanced gallery modal** with advanced features:
  - 2x zoom toggle
  - Fullscreen mode
  - Image download
  - Thumbnail navigation strip
  - Touch/swipe support for mobile
  - Keyboard shortcuts (arrows, space, ESC)
  - Loading states with spinner
  - Image preloading for smooth navigation
- Bulk image uploads (up to 5 images at once)
- **Image format normalization** (.jpeg → .jpg for consistency)
- Drag-and-drop support
- **Direct file copy** (preserves original quality and color)

### User Interface
- Responsive design with Tailwind CSS
- Dark mode support with system preference detection
- Interactive components with hover effects
- Modal galleries with keyboard navigation
- Lazy loading for images
- Toast notifications
- Gradient text and backgrounds
- Loading states
- **Preview mode for scheduled articles**
- **Device toggle (desktop/tablet/mobile) for previews**

### Layout Components
- Featured articles showcase
- Latest articles grid/list view
- Article headers with cover images
- Image galleries with modal viewer
- Category badges and filters
- Responsive sidebar
- Related articles section
- **Preview banner for scheduled articles**

## 🗂 Application Structure

### Models
```
/app/Models
├── User.php                # User authentication and profile
├── Article.php            # Article model with relationships
├── Category.php          # Category management
├── Media.php             # Media/image handling
└── Comment.php           # Article comments (if implemented)
```

### Controllers
```
/app/Http/Controllers
├── Admin/
│   ├── AdminArticleController.php    # Article CRUD operations
│   ├── AdminCategoryController.php   # Category management
│   ├── AdminDashboardController.php  # Admin dashboard with statistics
│   ├── AdminImageController.php      # Image upload & processing (NEW)
│   ├── AdminMediaController.php      # Media library management
│   ├── AdminPartnersController.php   # Partners management
│   ├── AdminSettingController.php    # Site settings (SEO, brand, API keys)
│   └── AdminTeamController.php       # Team member management
├── Frontend/
│   ├── HomeController.php            # Homepage with featured articles
│   ├── SearchController.php          # Article search functionality
│   ├── ShowArticleController.php     # Article display & preview
│   └── ShowCategoryController.php    # Category page display
└── Auth/
    └── AuthenticatedSessionController.php  # Authentication
```

### View Components (Refactored Structure)
```
/resources/views/components
├── admin/                            # Admin panel components
│   ├── article/
│   │   ├── gallery-create.blade.php  # Image upload for new articles
│   │   ├── gallery-edit.blade.php    # Article gallery editor with AJAX
│   │   ├── options.blade.php         # Social media links (YouTube, Instagram)
│   │   ├── publish-option.blade.php  # Category & publish date picker
│   │   ├── schedule-option.blade.php # Scheduled articles calendar
│   │   └── seo.blade.php             # SEO validation and metrics
│   ├── form/                         # Reusable form components
│   │   ├── date-input.blade.php
│   │   ├── file-input.blade.php
│   │   ├── input.blade.php
│   │   ├── select.blade.php
│   │   ├── textarea.blade.php
│   │   └── text-input.blade.php
│   ├── media/
│   │   └── gallery.blade.php         # Media library management
│   ├── breadcrumbs.blade.php         # Navigation breadcrumbs
│   ├── navigation.blade.php          # Admin navigation menu
│   ├── page-header.blade.php         # Page headers with actions
│   ├── stats-card.blade.php          # Dashboard statistics
│   └── modal-confirm-delete.blade.php # Delete confirmation modal
├── frontend/                         # Public-facing components
│   └── article/
│       ├── card-with-image.blade.php # Article card with image
│       ├── card-no-image.blade.php   # Article card fallback
│       ├── gallery.blade.php         # Enhanced 4-column gallery grid
│       ├── header.blade.php          # Article header with cover
│       ├── modal-gallery.blade.php   # Full-featured gallery modal
│       ├── options.blade.php         # Social media links display
│       └── related.blade.php         # Related articles (3 max)
├── home/                             # Homepage components
│   ├── featured.blade.php            # Featured article showcase
│   ├── latest.blade.php              # Latest articles with grid/list toggle
│   ├── latest-grid.blade.php         # Grid view for articles
│   └── latest-list.blade.php         # List view for articles
├── sidebar/                          # Sidebar components
│   ├── ads.blade.php                 # Advertisement placeholder
│   ├── popular.blade.php             # Popular articles widget
│   ├── search.blade.php              # Article search with AJAX
│   ├── share.blade.php               # Social sharing buttons
│   └── sidebar.blade.php             # Main sidebar wrapper
├── auth/                             # Authentication components
│   ├── card.blade.php                # Auth card wrapper
│   └── logo.blade.php                # Auth logo
├── header.blade.php                  # Main site header
├── footer.blade.php                  # Main site footer
├── notification.blade.php            # Toast notifications
└── scroll-top.blade.php              # Back to top button
```

### Routes
```
/routes
├── web.php                # Public web routes
├── admin.php             # Admin panel routes
└── auth.php              # Authentication routes
```

### Key Route Groups
```php
// Public Routes
Route::get('/', [HomeController::class, 'index']);
Route::get('/articles/{slug}', [ArticleController::class, 'show']);
Route::get('/categories/{slug}', [CategoryController::class, 'show']);
Route::get('/preview/articles/{slug}', [ShowArticleController::class, 'preview'])->name('articles.preview');

// Admin Routes (Prefix: /admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('articles', AdminArticleController::class);
    Route::get('articles/scheduled', [AdminArticleController::class, 'scheduled'])->name('articles.scheduled');
    Route::resource('categories', AdminCategoryController::class);
    Route::resource('media', AdminMediaController::class);
});
```

### Layouts
```
/resources/views/layouts
├── app.blade.php          # Main application layout
├── admin.blade.php        # Admin panel layout
├── article.blade.php      # Article display layout
└── guest.blade.php        # Guest/public layout
```

### Assets Organization
```
/resources
├── css/
│   └── app.css           # Main stylesheet
├── js/
│   └── app.js            # Main JavaScript file
└── views/
    ├── admin/            # Admin panel views
    ├── articles/         # Article views
    ├── auth/             # Authentication views
    ├── components/       # Blade components
    └── layouts/          # Layout templates
```

### Database Structure
```
/database/migrations
├── create_users_table.php
├── create_articles_table.php
├── create_categories_table.php
├── create_media_table.php
└── create_article_category_table.php
```

### Key Features Implementation
- **Media Management**: Advanced image handling with ICC color profile preservation
- **Article System**: Full CRUD with category management, media galleries, and social links
- **Authentication**: User registration, login, and admin role management
- **Frontend**: Responsive layouts with Tailwind CSS and Alpine.js
- **Dynamic SEO**: Admin-configurable meta tags, Open Graph tags, and keywords
- **Performance**: Direct file copy (no processing), lazy loading, and image preloading
- **Article Preview**: Preview system for scheduled articles with admin-only access
- **Scheduled Articles**: Calendar view and management for scheduled content
- **Enhanced Gallery**: Modern modal with zoom, fullscreen, download, and touch support
- **Settings Management**: Centralized settings for SEO, brand, social media, and API keys

### Service Providers
```
/app/Providers
├── AppServiceProvider.php          # Application service bindings
├── AuthServiceProvider.php         # Authentication policies
├── RouteServiceProvider.php        # Route configurations
└── ViewServiceProvider.php         # View composers and shared data
```

## 🎨 Design System

### UI Components
- **Typography**:
  - Gradient text effects
  - Responsive font sizing
  - Custom prose styling for articles

- **Cards & Containers**:
  - Hover effects with shadows
  - Gradient borders
  - Rounded corners with consistent spacing
  - Dark mode variants

- **Images & Media**:
  - Aspect ratio containers
  - Cover/contain sizing options
  - Lazy loading
  - Hover zoom effects
  - Modal previews

- **Navigation**:
  - Responsive header
  - Sticky sidebar
  - Category filters
  - Breadcrumbs

### Interactive Elements
- **Enhanced modal gallery** with:
  - Keyboard navigation (arrows, space, ESC)
  - Touch/swipe gestures for mobile
  - 2x zoom toggle
  - Fullscreen mode
  - Image download
  - Thumbnail navigation strip
  - Loading states with spinner
  - Image counter (e.g., "3 / 10")
- Grid/List view toggles with smooth transitions
- Drag-and-drop image upload zones with preview
- Toast notifications with color-coded types (success/error/warning/info)
- Real-time loading states and progress indicators
- Smooth hover effects and scale animations
- **Preview mode toggle** (desktop/tablet/mobile)
- **Scheduled articles calendar** with month navigation
- **AJAX form submissions** with live feedback
- **Delete confirmation modals** with custom styling

## 🚀 Installation

Follow these steps to set up the project locally:

### 1. Clone the Repository

```bash
git clone https://github.com/your-repository/valero.git
cd valero
```

### 2. Install Dependencies

```bash
composer install
npm install
```

### 3. Set Up Environment Variables

Create a `.env` file by copying `.env.example`:

```bash
cp .env.example .env
```

Update the `.env` file with your database credentials and mail settings:

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

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Run Migrations

```bash
php artisan migrate
```

### 6. Create Storage Link

Ensure that the storage is linked to serve uploaded images:

```bash
php artisan storage:link
```

### 7. Seed the Database (Optional)

For demo purposes, seed the database with sample data:
User: admin@example.com
Password: password 

```bash
php artisan db:seed
php artisan db:seed --class=DemoSeeder
```

If you are not using seed option and prefer to manually register users, you need to manually update at least one user
in the database and set the role to `admin`. 

```bash
update users set role='admin', email_verified_at=now() where id = 1;
```

### 8. Compile Front-End Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 9. Run the Application

Start the local development server:

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser to access Valero.

## 🔄 Updates & Versioning

**Current Version: 0.42293**

### Latest Updates (December 2025)
- ✨ **Dynamic SEO Management**: Admin panel for meta tags, Open Graph, and keywords
- ✨ **Enhanced Gallery System**: Modern modal with zoom, fullscreen, download, thumbnails
- ✨ **Image Processing**: ICC color profile preservation, .jpeg→.jpg normalization
- ✨ **View Structure Refactoring**: Laravel naming conventions, organized components
- ✨ **Smart Paste Handler**: TinyMCE preserves lists, formatting, and indentation
- ✨ **AJAX Image Management**: Set cover and delete without page reload
- ✨ **Touch Gestures**: Swipe support for mobile gallery navigation
- ✨ **Image Preloading**: Adjacent images preload for smooth navigation
- ✨ **Settings API**: Centralized settings with app_ prefix in database
- ✨ **Toast System**: Global notification system with color-coded types
- 🗑️ **Code Cleanup**: Removed unused components and optimized bundle size
- 🐛 **Bug Fixes**: Image upload validation, dimension display, file size calculation

### Previous Updates
- Added article preview system for scheduled content
- Implemented scheduled articles calendar view
- Enhanced admin article management with preview capabilities
- Added device toggle for article previews (desktop/tablet/mobile)
- Improved scheduled articles management interface
- Enhanced media library management
- Added related articles functionality (modern 3-column layout)
- Optimized image loading and display
- Improved dark mode implementation

## 🛠 Development

### Prerequisites
- PHP 8.2+
- Node.js & NPM
- Composer
- MySQL 8.0+

### Local Development
We use Laravel Herd for local development but you can use any other local development tool.

```bash
npm run dev
```

### Production Build
```bash
npm run build
php artisan optimize
```

---

## 🎨 UI and UX Enhancements

The UI follows a **minimalist design** with modern, interactive elements using **Tailwind CSS**:

- Interactive components with hover effects and smooth transitions
- Responsive tables with row hover effects
- Dark mode with system preference detection and manual toggle
- **Advanced modal gallery**:
  - Fullscreen mode with backdrop blur
  - 2x zoom with cursor indicators
  - Download images directly
  - Thumbnail strip with auto-scroll
  - Touch swipe gestures
  - Keyboard shortcuts
  - Loading spinner transitions
- Real-time character counting for content fields
- Drag-and-drop file upload zones with live preview
- **Enhanced toast notifications**:
  - Color-coded types (success, error, warning, info)
  - Auto-dismiss with progress bar
  - Custom icons per type
  - Smooth animations
- **Preview mode for scheduled articles** with device toggle
- **Scheduled articles calendar** with visual indicators
- **AJAX operations** without page reload (set cover, delete images)
- **Smart paste** preserves formatting in TinyMCE editor

## 🎨 Design & UI Components

- **Logo font**: Protest Guerrilla
- **Icons**: [Lucide Icons](https://lucide.dev/icons/) (300+ icons)
- **Rich Text Editor**: TinyMCE 6 with smart paste handler
- **Image Gallery**: 
  - 4-column responsive grid (2 on mobile, 3 on tablet)
  - Modal viewer with fullscreen, zoom, download
  - Thumbnail navigation strip
  - Touch/swipe support
  - Keyboard shortcuts (←→ arrows, space, ESC)
  - Image preloading for smooth navigation
- **Dark Mode**: System preference detection with manual toggle
- **Email Templates**: Custom HTML templates with dark mode support
- **Preview System**: Admin-only preview for scheduled articles
- **Settings UI**: Organized cards for SEO, Brand, API, Social Media
- **Toast Notifications**: Color-coded with auto-dismiss and progress bars

## 🤝 Future Enhancements

- **Enhanced User Authentication**: 
  - Social login integration (Google, GitHub)
  - OAuth2 support
  - Advanced role permissions (editor, contributor)
- **Email Customization**: 
  - Customizable email templates
  - Multiple language support for emails
  - Email notification preferences
- **Advanced SEO**: 
  - JSON-LD structured data
  - Automatic sitemap generation
  - Social media card previews
- **Article Features**:
  - Comments system with moderation
  - Article bookmarks/favorites
  - Reading progress indicator
  - Print-friendly view
- **Dashboard Enhancements**: 
  - Real-time analytics
  - Traffic statistics with charts
  - Popular articles tracking
  - Category performance metrics
- **Preview System**: 
  - Shareable preview links
  - Preview comments for team review
  - Preview link expiration for security
- **Media Enhancements**:
  - Image crop/resize tool in admin
  - WebP automatic conversion
  - CDN integration
  - Video upload support

## 🤝 Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

## 📝 License

This project is open-source and licensed under the [MIT license](LICENSE).

### ❤️ Thanks for checking out **Valero**! Happy coding!