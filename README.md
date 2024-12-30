# Valero - Blogging Platform

Valero is an open-source article-sharing platform built with **Laravel 11** and **Livewire**. It features a modern, responsive design with advanced media management and article organization capabilities.

## 📦 Core Features

### Article Management
- Full CRUD operations for articles
- Rich text editor integration
- Cover image designation
- Multiple image galleries per article
- Automatic reading time calculation
- Related articles functionality
- SEO optimization
- Article scheduling and drafts
- Category organization

### Media Management
- Dedicated media library with grid view
- Image metadata tracking:
  - Dimensions
  - File size
  - Upload date
  - Article association
- Cover image designation
- Gallery modal with navigation
- Bulk image uploads
- Image optimization
- Drag-and-drop support

### User Interface
- Responsive design with Tailwind CSS
- Dark mode support with system preference detection
- Interactive components with hover effects
- Modal galleries with keyboard navigation
- Lazy loading for images
- Toast notifications
- Gradient text and backgrounds
- Loading states

### Layout Components
- Featured articles showcase
- Latest articles grid/list view
- Article headers with cover images
- Image galleries with modal viewer
- Category badges and filters
- Responsive sidebar
- Related articles section

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
│   ├── AdminController.php           # Base admin functionality
│   ├── ArticleController.php         # Article CRUD operations
│   ├── CategoryController.php        # Category management
│   ├── MediaController.php           # Media library management
│   └── DashboardController.php       # Admin dashboard
├── Auth/
│   └── AuthenticatedSessionController.php  # Authentication
├── ArticleController.php             # Public article display
├── HomeController.php                # Homepage and listings
└── ProfileController.php             # User profile management
```

### View Components
```
/resources/views/components
├── admin/
│   ├── media/
│   │   └── gallery.blade.php         # Media library management
│   ├── article/
│   │   └── gallery-edit.blade.php    # Article gallery editor
│   ├── page-header.blade.php         # Admin page headers
│   └── stats-card.blade.php          # Statistics display
├── article/
│   ├── header.blade.php              # Article header with cover
│   ├── gallery.blade.php             # Article image gallery
│   ├── related.blade.php             # Related articles
│   ├── has-image.blade.php           # Image display handler
│   ├── no-image.blade.php            # Fallback for missing images
│   └── fullgallery.blade.php         # Full-screen gallery modal
├── home/
│   ├── home-featured-articles.blade.php
│   ├── home-latest-articles-grid.blade.php
│   └── home-latest-articles-list.blade.php
└── sidebar/
    └── sidebar.blade.php             # Sidebar with categories
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

// Admin Routes (Prefix: /admin)
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('articles', AdminArticleController::class);
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
- **Media Management**: Handles image uploads, optimization, and gallery management
- **Article System**: Full CRUD with category management and media attachments
- **Authentication**: User registration, login, and admin role management
- **Frontend**: Responsive layouts with Tailwind CSS and Alpine.js
- **SEO**: Meta tags, slugs, and optimized URLs
- **Performance**: Image optimization, lazy loading, and caching

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
- Modal galleries with keyboard navigation
- Grid/List view toggles
- Image upload zones
- Toast notifications
- Loading states
- Hover effects

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

**Current Version: 0.39940**
- Enhanced media library management
- Improved article gallery system
- Added related articles functionality
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
- Modal image gallery with keyboard navigation
- Real-time character counting for content fields
- Drag-and-drop file upload zones
- Toast notifications for user feedback

## 🎨 Design & UI Components

- **Logo font**: Protest Guerrilla
- **Icons**: [Lucide Icons](https://lucide.dev/icons/)
- **Rich Text Editor**: TinyMCE 6
- **Image Gallery**: Custom modal viewer with keyboard navigation
- **Dark Mode**: System preference detection with manual toggle
- **Email Templates**: Custom HTML templates with dark mode support

## 🤝 Future Enhancements

- **Enhanced User Authentication**: 
  - Social login integration
  - OAuth2 support
  - Advanced role permissions
- **Email Customization**: 
  - Customizable email templates
  - HTML email support
  - Multiple language support for emails
- **SEO Enhancements**: Improve the existing SEO functionality by adding more meta tags and optimizing social media previews.
- **Article Search**: Add a search functionality to find articles based on title or content.
- **Dashboard Statistics**: Implement more detailed statistics on articles and categories in the admin dashboard.

## 🤝 Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

## 📝 License

This project is open-source and licensed under the [MIT license](LICENSE).

### ❤️ Thanks for checking out **Valero**! Happy coding!