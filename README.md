# Valero - Blogging Platform

Valero is an open-source article-sharing platform built with **Laravel 10** and **Livewire**. It allows users to create, edit, and share blog-style articles with features such as categories, images, galleries, and SEO optimization.

![Valero Logo](valero_kit/logo_light/web/icon-192.png)

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

- **Frontend Controllers**: Handle public-facing article display and interactions
- **Admin Controllers**: Manage CRUD operations for articles, categories, and settings
- **Livewire Components**: Handle real-time interactions and dynamic content updates
- **Blade Components**: Reusable UI components for consistent design
- **SEO Integration**: Automatic meta tags and sitemap generation

### Views Structure:

1. **Layouts**:
   - `home.blade.php`: Main public layout
   - `article.blade.php`: Article display layout
   - `admin.blade.php`: Admin panel layout
   - `category.blade.php`: Category view layout

2. **Components**:
   - Article components (header, gallery, related articles)
   - Sidebar components (search, popular articles, sharing)
   - Admin components (forms, modals, tables)
   - Common UI components (navigation, footer, buttons)

3. **Admin Views**:
   - Article management (CRUD operations)
   - Category management
   - Settings management
   - User profile management

### Features Implementation:

1. **Article System**:
   - Featured image handling
   - Gallery management
   - Reading time calculation
   - View counting
   - Like system
   - Scheduled publishing

2. **SEO Features**:
   - Meta tags generation
   - Social media previews
   - Sitemap generation
   - Google Search Console integration

3. **User System**:
   - Profile management
   - Avatar uploads
   - Social media links
   - Two-factor authentication support

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
