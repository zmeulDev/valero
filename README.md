# Valero - Blogging Platform

Valero is an open-source article-sharing platform built with **Laravel 10** and **Livewire**. It allows users to create, edit, and share blog-style articles with features such as categories, images, galleries, and SEO optimization.

## 📦 Features

- **Article Management**: Create, edit, schedule, and publish articles with image uploads and galleries.
- **Category Management**: Dynamically create and manage categories via a Livewire-powered modal.
- **Admin Panel**: Full CRUD operations for managing articles, categories, and users with a clean and responsive interface.
- **Livewire Integration**: Dynamic, real-time components for a seamless user experience.
- **Tailwind CSS**: Modern and responsive design with utility-first CSS framework.
- **SEO Optimization**: Integrated with the **RalphJSmit/Laravel/SEO** package for enhanced search engine visibility.
- **Dark Mode Support**: Toggle between light and dark themes for user comfort.
- **Reading Time Estimation**: Displays estimated reading time for articles.
- **View Count**: Tracks and displays the number of views for each article.
- **Responsive Design**: Optimized for all screen sizes, ensuring a consistent experience across devices.
- **Comments System**: Nested comments with real-time updates and moderation capabilities.
- **User Profiles**: Customizable user profiles with avatars and social links.
- **Social Sharing**: Built-in social media sharing functionality.
- **Article Likes**: User engagement through article likes system.
- **Popular Articles**: Sidebar widget showing most viewed articles.
- **Search Functionality**: Search articles by title and content.

## 🗂 Application Structure

### Key Components:

```
/app
├── Actions
│   ├── Fortify
│   │   ├── CreateNewUser.php - Handles user registration
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

Update the `.env` file with your database credentials and other environment-specific values (like `APP_NAME`).

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

```bash
php artisan db:seed
php artisan db:seed --class=ArticleSeeder
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

The UI follows a **minimalist design** with modern, interactive elements using **Tailwind CSS**. Hover effects, shadows, and transitions have been applied to buttons and table rows for a clean and intuitive user experience.

- Buttons have hover effects and smooth transitions.
- Form elements are styled for clarity and ease of use.
- Tables in the admin panel have subtle row hover effects, making it easier to manage content.
- Dark mode support for a more comfortable reading experience in low-light conditions.

---

## 🔮 Future Enhancements

- **User Authentication and Roles**: Further define roles (admin, editor, user) and manage access permissions.
- **SEO Enhancements**: Improve the existing SEO functionality by adding more meta tags and optimizing social media previews.
- **Article Search**: Add a search functionality to find articles based on title or content.
- **Dashboard Statistics**: Implement more detailed statistics on articles and categories in the admin dashboard.

---

## 🎨 Design

- **Logo font**: Protest Guerrilla.
- **Icons**: Lucide. https://lucide.dev/icons/

---

## 🤝 Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

---

## 📝 License

This project is open-source and licensed under the [MIT license](LICENSE).

---

### ❤️ Thanks for checking out **Valero**! Happy coding!