# Valero - Blogging Platform

Valero is an open-source article-sharing platform built with **Laravel 11** and **Livewire**. It allows users to create, edit, and share blog-style articles with features such as categories, images, galleries, and SEO optimization.

[View Screenshots](./screenshots)

## 📦 Features

- **Article Management**: Create, edit, schedule, and publish articles with image uploads and galleries.
- **Category Management**: Dynamically create and manage categories via a Livewire-powered modal.
- **Admin Panel**: Full CRUD operations for managing articles, categories, and users with a clean and responsive interface.
- **Rich Text Editor**: 
  - TinyMCE 6 integration
  - Markdown support
  - Code block highlighting
  - Image embedding
  - Custom paste handling
- **Image Management**:
  - Gallery support with modal viewer
  - Keyboard navigation for galleries
  - Image optimization
  - Drag-and-drop upload support
  - Bulk image uploads
- **SEO Optimization**: Integrated with the **RalphJSmit/Laravel/SEO** package for enhanced search engine visibility.
- **Dark Mode**: System preference detection with manual toggle and theme persistence
- **Reading Time**: Automatic calculation of estimated reading time
- **View Tracking**: Real-time view count tracking
- **Character Limits**:
  - Title (60 characters)
  - Excerpt (160 characters)
  - Real-time character counting
- **Responsive Design**: Mobile-first approach with Tailwind CSS
- **User Authentication**: 
  - Email verification
  - Two-factor authentication
  - Profile management
  - Session handling

## 🗂 Application Structure

### Key Components:

```
/app
├── Actions
│   ├── Fortify
│   │   ├── CreateNewUser.php - Handles user registration with email verification
│   │   ├── PasswordValidationRules.php - Defines password validation rules
│   │   ├── ResetUserPassword.php - Handles password reset functionality
│   │   ├── UpdateUserPassword.php - Handles password updates
│   │   └── UpdateUserProfileInformation.php - Manages profile updates
│   └── Jetstream
│       └── DeleteUser.php - Handles user account deletion
├── Console
│   └── Kernel.php - Defines scheduled tasks
├── Http
│   ├── Controllers
│   │   ├── Admin
│   │   │   ├── AdminArticleController.php - Manages articles (CRUD)
│   │   │   ├── AdminCategoryController.php - Manages categories (CRUD)
│   │   │   ├── AdminDashboardController.php - Handles admin dashboard stats/display
│   │   │   ├── AdminImageController.php - Handles image uploads/management
│   │   │   ├── AdminPartnersController.php - Manages partner ads (CRUD + status management)
│   │   │   ├── AdminSettingController.php - Handles site settings
│   │   │   ├── AdminSitemapController.php - Generates sitemap
│   │   │   └── AdminTeamController.php - Manages team members
│   │   └── Frontend
│   │       ├── HomeController.php - Handles homepage display
│   │       ├── SearchController.php - Manages search functionality
│   │       ├── ShowArticleController.php - Displays individual articles
│   │       └── ShowCategoryController.php - Shows category-specific articles
│   └── Middleware
│       ├── AdminMiddleware.php - Controls access to admin area based on roles
│       └── AdminOnlyMiddleware.php - Ensures only admins can access certain routes
├── Models
│   ├── Article.php - Article data model with relationships
│   ├── Category.php - Category data model
│   └── Image.php - Image data model for article galleries
```

### Database Structure:

```
/database
├── migrations
│   ├── 0001_01_01_000000_create_users_table.php - Creates users table
│   ├── 2024_09_17_082456_create_articles_table.php - Creates articles table
│   ├── 2024_09_17_083239_create_images_table.php - Creates images table
│   ├── 2024_09_17_120026_create_categories_table.php - Creates categories table
│   ├── 2024_09_26_125810_create_seo_table.php - Creates SEO table
│   ├── 2024_10_03_075454_create_settings_table.php - Creates settings table
│   └── 2024_11_05_114007_create_partners_table.php - Creates partners table
├── seeders
│   ├── DatabaseSeeder.php - Main seeder to run all other seeders
│   ├── ArticleSeeder.php - Seeds articles
│   ├── CategorySeeder.php - Seeds categories
│   └── SettingSeeder.php - Seeds application settings
```

### Explanation of Key Database Files:

1. **Migrations**: Define the structure of the database tables, including users, articles, categories, images, and settings.
2. **Seeders**: Populate the database with initial data for testing and development.

### Frontend Structure:

```
/resources
├── views
│   ├── auth - Handles user authentication (login, registration, password reset)
│   ├── components - Reusable UI components (buttons, forms, modals)
│   ├── layouts - Main layout files for the application (admin layout, guest layout)
│   ├── admin - Manage articles, categories, partners, and settings
│   └── frontend - Display articles and categories to the public
```

### Explanation of Key View Files:

1. **Auth Views**: Handle user authentication (login, registration, password reset).
2. **Components**: Reusable UI components for consistent design.
3. **Layouts**: Main layout files for the application.
4. **Admin Views**: Manage articles, categories, partners, and settings.
5. **Frontend Views**: Display articles and categories to the public.

### Configuration Files:

- **`tailwind.config.js`**: Configuration for Tailwind CSS, defining custom styles and themes.
- **`app/Providers/CookiesServiceProvider.php`**: Handles cookie consent and management.

### Authentication Features:

1. **Email Verification**:
   - Mandatory email verification for new users
   - Resend verification email functionality
   - Email verification status indicator
   - Secure verification links

2. **User Management**:
   - Secure password hashing
   - Profile photo upload
   - Two-factor authentication
   - Session management

### Conclusion

This structure allows for a clear separation of concerns, making the application easier to maintain and extend. Each component, controller, and model has a specific role, contributing to the overall functionality of the Valero blogging platform.

---

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

### 5. Publish SEO Package Configuration and Migrations

```bash
php artisan vendor:publish --provider="RalphJSmit\Laravel\SEO\SEOServiceProvider"
```

### 6. Run Migrations

```bash
php artisan migrate
```

### 7. Create Storage Link

Ensure that the storage is linked to serve uploaded images:

```bash
php artisan storage:link
```

### 8. Seed the Database (Optional)

For demo purposes, seed the database with sample data:
User: admin@example.com
Password: password  

```bash
php artisan db:seed
php artisan db:seed --class=DemoSeeder
```

### 9. Compile Front-End Assets

For development:

```bash
npm run dev
```

For production:

```bash
npm run build
```

### 10. Run the Application

Start the local development server:

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser to access Valero.

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

## Current Version

**Version 0.39940**
- Added TinyMCE rich text editor integration
- Improved image gallery management
- Enhanced dark mode persistence
- Added character count limits
- Implemented keyboard navigation for galleries
- Added bulk image upload support
- Improved admin panel UI/UX

---

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

---

## 🤝 Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

---

## 📝 License

This project is open-source and licensed under the [MIT license](LICENSE).

---

### ❤️ Thanks for checking out **Valero**! Happy coding!