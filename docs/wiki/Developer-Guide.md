# Developer Guide

Technical documentation for developers working with Valero.

## 🏗️ Architecture

### Application Structure

```
valero/
├── app/
│   ├── Http/Controllers/    # Request handlers
│   ├── Models/              # Eloquent models
│   ├── Services/           # Business logic
│   └── View/Components/    # Blade components
├── database/
│   ├── migrations/         # Database schema
│   └── seeders/            # Database seeders
├── resources/
│   ├── views/              # Blade templates
│   ├── lang/               # Translations
│   ├── js/                 # JavaScript
│   └── css/                # Stylesheets
└── routes/
    └── web.php             # Web routes
```

### Design Patterns

- **MVC** - Model-View-Controller
- **Repository Pattern** - Data access abstraction
- **Service Layer** - Business logic separation
- **Component-Based** - Reusable UI components

## 🔧 Development Setup

### Local Environment

```bash
# Clone repository
git clone https://github.com/zmeuldev/valero.git
cd valero

# Install dependencies
composer install
npm install

# Setup environment
cp .env.example .env
php artisan key:generate

# Setup database
php artisan migrate
php artisan db:seed

# Build assets
npm run dev

# Start server
php artisan serve
```

### IDE Configuration

#### PHPStorm/IntelliJ

- Install Laravel plugin
- Configure PHP interpreter
- Enable Laravel IDE helper

#### VS Code

Recommended extensions:
- PHP Intelephense
- Laravel Blade Snippets
- Tailwind CSS IntelliSense

## 📦 Key Components

### Models

#### Article Model

```php
// app/Models/Article.php
class Article extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 
        'category_id', 'published_at'
    ];
    
    public function media()
    {
        return $this->hasMany(Media::class);
    }
}
```

#### Media Model

```php
// app/Models/Media.php
class Media extends Model
{
    protected $fillable = [
        'article_id', 'image_path', 
        'is_cover', 'alt_text'
    ];
    
    public function article()
    {
        return $this->belongsTo(Article::class);
    }
}
```

### Controllers

#### Admin Controllers

Located in `app/Http/Controllers/Admin/`:

- `AdminArticleController` - Article CRUD
- `AdminMediaController` - Media management
- `AdminBookmarkController` - Bookmark management
- `AdminSettingController` - Settings management

#### Frontend Controllers

Located in `app/Http/Controllers/Frontend/`:

- `HomeController` - Homepage
- `ShowArticleController` - Article display
- `ShowCategoryController` - Category pages

### Services

Business logic in `app/Services/`:

- `ArticleService` - Article operations
- `AssetService` - Asset management

### Components

Blade components in `resources/views/components/`:

- `admin/` - Admin panel components
- `frontend/` - Public-facing components
- `auth/` - Authentication components

## 🗄️ Database

### Migrations

Create migrations:
```bash
php artisan make:migration create_table_name
```

Run migrations:
```bash
php artisan migrate
```

### Relationships

#### Article Relationships

```php
// Article has many Media
$article->media

// Article belongs to Category
$article->category

// Article has one SEO
$article->seo
```

#### Media Relationships

```php
// Media belongs to Article
$media->article
```

### Indexes

Important indexes:
- `articles.slug` - Unique
- `media.image_path` - For reference counting
- `bookmarks.user_id` - User isolation
- `bookmarks.category` - Category filtering

## 🎨 Frontend

### JavaScript

#### Admin JavaScript

`resources/js/valero-admin.js`:
- Gallery management
- Media library
- Form handling
- Alpine.js components

#### Frontend JavaScript

`resources/js/valero-frontend.js`:
- Frontend interactions
- Auth forms
- Search functionality

### Styling

#### Tailwind CSS

Configuration: `tailwind.config.js`

Custom colors:
```javascript
theme: {
  extend: {
    colors: {
      primary: {
        // Custom colors
      }
    }
  }
}
```

#### Dark Mode

Implemented via:
- System preference detection
- Manual toggle
- CSS classes: `dark:`

### Alpine.js

Used for:
- Component state management
- Form interactions
- Modal controls
- Dynamic UI updates

Example:
```javascript
x-data="{ open: false }"
@click="open = !open"
x-show="open"
```

## 🔌 API Endpoints

### Admin API

#### Media Library

```
GET /admin/media/library
POST /admin/articles/{article}/images/attach-from-library
```

#### Bookmarks

```
GET /admin/bookmarks/all
POST /admin/bookmarks
PUT /admin/bookmarks/{id}
DELETE /admin/bookmarks/{id}
```

### AJAX Responses

Standard JSON format:
```json
{
  "success": true,
  "message": "Operation successful",
  "data": {}
}
```

## 🧪 Testing

### Running Tests

```bash
# All tests
php artisan test

# Specific test
php artisan test --filter ArticleTest

# With coverage
php artisan test --coverage
```

### Writing Tests

```php
// tests/Feature/ArticleTest.php
public function test_can_create_article()
{
    $user = User::factory()->create(['role' => 'admin']);
    
    $response = $this->actingAs($user)
        ->post('/admin/articles', [
            'title' => 'Test Article',
            'content' => 'Content here'
        ]);
    
    $response->assertRedirect();
    $this->assertDatabaseHas('articles', [
        'title' => 'Test Article'
    ]);
}
```

## 🔐 Security

### Authentication

- Laravel Fortify for authentication
- Jetstream for 2FA
- Role-based access control

### Authorization

Middleware:
```php
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin routes
});
```

### CSRF Protection

All forms include CSRF tokens:
```blade
@csrf
```

### XSS Protection

Blade automatically escapes:
```blade
{{ $variable }}  <!-- Escaped -->
{!! $variable !!}  <!-- Raw (use carefully) -->
```

## 🚀 Performance

### Caching

```php
// Cache config
php artisan config:cache

// Cache routes
php artisan route:cache

// Cache views
php artisan view:cache
```

### Database Optimization

- Use indexes
- Eager loading: `with()`
- Query optimization
- Connection pooling

### Asset Optimization

```bash
# Production build
npm run build

# Development
npm run dev
```

## 📝 Code Style

### PHP

Follow PSR-12:
- 4 spaces indentation
- PSR-4 autoloading
- Type hints
- Docblocks

### JavaScript

- ES6+ features
- Consistent naming
- Comments for complex logic

### Blade

- Use components
- Keep templates clean
- Translation functions

## 🔄 Workflow

### Feature Development

1. Create feature branch
2. Implement feature
3. Write tests
4. Update documentation
5. Submit PR

### Bug Fixes

1. Create bugfix branch
2. Fix the bug
3. Add test case
4. Submit PR

## 📚 Resources

### Laravel Documentation
- [Laravel 11 Docs](https://laravel.com/docs/11.x)
- [Blade Templates](https://laravel.com/docs/11.x/blade)
- [Eloquent ORM](https://laravel.com/docs/11.x/eloquent)

### Frontend
- [Tailwind CSS](https://tailwindcss.com/docs)
- [Alpine.js](https://alpinejs.dev/)
- [TinyMCE](https://www.tiny.cloud/docs/)

### Tools
- [Laravel Debugbar](https://github.com/barryvdh/laravel-debugbar)
- [Laravel Telescope](https://laravel.com/docs/11.x/telescope)

---

**Need Help?** Check [Contributing](Contributing) or [open an issue](https://github.com/zmeuldev/valero/issues).

