# Valero - Bloging Platform

Valero is an open-source article-sharing platform built with **Laravel 11** and **Livewire**. It allows users to create, edit, and share blog-style articles with features such as categories, images, and galleries. The admin interface includes full CRUD operations for managing articles, categories, and a modal-based category creation interface.

## Features

- Article management with image uploads, galleries, and scheduling.
- Category management with dynamic modal creation.
- Admin panel for managing articles, categories, and users.
- Integration with **Livewire** for dynamic, real-time components.
- Responsive and clean design with **Tailwind CSS**.
- A **minimalistic UI** for a modern user experience.
  
---

## Installation

To set up the project locally, follow these steps:

1. **Clone the repository:**

```bash
git clone https://github.com/your-repository/valero.git
cd valero
```

2. **Install dependencies:**

```bash
composer install
npm install
```

3. **Set up environment variables:**

Create a `.env` file by copying `.env.example`:

```bash
cp .env.example .env
```

Update the `.env` file with your database credentials and other environment-specific values (like `APP_NAME`).

4. **Run migrations:**

```bash
php artisan migrate
```

5. **Run the application:**

```bash
php artisan serve
```

For front-end assets, use:

```bash
npm run dev
```

---

## Application Structure

The application follows the standard **Laravel** structure with a focus on component-based architecture using **Livewire**.

### Key Components:

- **Article Management**: Articles can be created, edited, scheduled, and published, with options for adding featured images and gallery images.
- **Category Management**: Categories can be dynamically created via a Livewire modal and are used to organize articles.
- **Admin Panel**: The admin interface allows full CRUD operations on articles and categories, with optimized UI for usability and a modern look.

### Blade Components and Layouts:

- `resources/views/layouts/admin.blade.php`: The main layout used in the admin panel for managing articles, categories, and users.
- `resources/views/livewire/create-category-modal.blade.php`: A Livewire-powered modal for creating categories.

### Routes:

Key routes for the application are defined in `routes/web.php`. Some important routes include:

- `/admin/articles`: CRUD routes for managing articles.
- `/admin/categories`: CRUD routes for managing categories.
- `/admin/articles/{article}/images/{image}`: Route for deleting images from an article's gallery.

### Livewire Components:

1. **`CreateCategoryModal`**:
   - A dynamic modal for creating categories.
   - Triggered by emitting Livewire events from other Blade files.
   - Provides real-time feedback and form validation.

### Example Routes

- **Admin Articles Routes:**
  - `GET /admin/articles`: List of all articles.
  - `GET /admin/articles/create`: Form for creating a new article.
  - `POST /admin/articles`: Store a new article.
  - `GET /admin/articles/{id}/edit`: Edit an article.
  - `PUT /admin/articles/{id}`: Update an article.
  - `DELETE /admin/articles/{id}`: Delete an article.

- **Category Routes:**
  - `GET /admin/categories`: List of all categories.
  - `POST /admin/categories`: Store a new category via modal or form.

---

## Features Implemented

### 1. **Article Management**

Articles can be created with the following attributes:
- Title
- Excerpt
- Content
- Featured Image
- Gallery Images
- Scheduled Publish Date

The admin can view, edit, and delete articles, as well as upload images and preview them.

### 2. **Category Management**

- Admins can dynamically create and manage categories.
- A modal interface is available for seamless category creation without page refreshes.

### 3. **Livewire Modal**

The `CreateCategoryModal` component allows users to create categories via a modal. The modal is triggered using Livewire events and listens for `openModal` to dynamically display the form.

### 4. **File Uploads**

The application supports image uploads for both featured images and gallery images for articles. These images can be managed through the admin panel, with the option to delete gallery images.

---

## UI and UX Enhancements

The UI follows a **minimalist design** with modern, interactive elements using **Tailwind CSS**. Hover effects, shadows, and transitions have been applied to buttons and table rows for a clean and intuitive user experience.

- Buttons have hover effects and smooth transitions.
- Form elements are styled for clarity and ease of use.
- Tables in the admin panel have subtle row hover effects, making it easier to manage content.

---

## Future Enhancements

- **User Authentication and Roles**: Further define roles (admin, editor, user) and manage access permissions.
- **SEO Enhancements**: Implement meta tags and social media previews for articles.
- **Article Search**: Add a search functionality to find articles based on title or content.
- **Dashboard Statistics**: Implement more detailed statistics on articles and categories in the admin dashboard.

---

## Design

- **Logo font**: Protest Guerrilla.

---

## Contributing

Contributions are welcome! Please fork the repository and submit a pull request.

---

## License

This project is open-source and licensed under the [MIT license](LICENSE).

---

### Thanks for checking out **Valero**! Happy coding!
