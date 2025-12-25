# Valero

<div align="center">
  <h3>The Modern, Open-Source Blogging Platform</h3>
  <p>Built with Laravel 11, Livewire 3, and Tailwind CSS.</p>
</div>

---

**Valero** is a next-generation content management system designed for speed, SEO, and visual storytelling. It combines the power of **Laravel** with the reactivity of **Livewire** to deliver a seamless experience for both authors and readers.

Whether you're building a personal blog, a documentation hub, or a content-driven website, Valero provides the professional tools you need right out of the box.

## ✨ Why Valero?

### 🚀 **Engineered for Performance**
- **Blazing Fast**: Optimized database queries, caching strategies, and lazy-loading.
- **Modern Stack**: Built on **Laravel 11** and **Livewire 3** for a SPA-like feel without the complexity.
- **Production Ready**: Includes automated sitemaps, image optimization, and secure authentication.

### 🎨 **Visual Storytelling**
- **Advanced Media Library**: Drag-and-drop uploads, ICC color profile preservation, and smart image reuse.
- **Beautiful Galleries**: Integrated modal galleries with zoom, full-screen, and mobile touch support.
- **Cover Images**: automated resizing and optimization for social sharing cards.

### 🔍 **SEO First**
- **Google Standards**: Automated `BlogPosting` and `FAQPage` schemas.
- **Dynamic Meta**: Full control over title tags, descriptions, and Open Graph images.
- **Discover Ready**: Optimized for Google Discover visibility.

### 📚 **Series & Knowledge**
- **[NEW] Article Playlists**: Group articles into ordered series (e.g., "Laravel Mastery: Part 1") for sequential learning.
- **Bookmarking System**: Save and organize external resources directly within your writing workflow.
- **Scheduled Publishing**: Plan content with a visual calendar and device-specific previews.

---

## 📦 Key Features

### ✍️ **Writing Experience**
- **Rich Text Editor**: TinyMCE integration with smart paste handling (preserves formatting from Word/Docs).
- **Auto-Reading Time**: Calculates reading time automatically.
- **Smart Drafts**: Auto-save and draft management.

### 🖼️ **Media Powerhouse**
- **Reference Counting**: Smart deletion ensures shared images aren't removed accidentally.
- **Bulk Uploads**: Upload 30+ images at once with live progress.
- **Metadata**: Automatic tracking of dimensions, size, and alt text.

### 🌍 **Global & Accessible**
- **Multi-Language**: Native support for English (`en`) and Romanian (`ro`).
- **Dark Mode**: System-aware dark/light mode integration.
- **Accessibility**: Built with semantic HTML and ARIA standards.

---

## 🛠️ Tech Stack

- **Framework**: [Laravel 11](https://laravel.com)
- **Frontend**: [Livewire 3](https://livewire.laravel.com) + [Alpine.js](https://alpinejs.dev)
- **Styling**: [Tailwind CSS](https://tailwindcss.com)
- **Icons**: [Lucide](https://lucide.dev)

---

## 🚀 Getting Started

### Prerequisites
- PHP 8.2+
- Node.js & NPM
- MySQL 8.0+

### Installation

1. **Clone the repo**
   ```bash
   git clone https://github.com/zmeuldev/valero.git
   cd valero
   ```

2. **Install dependencies**
   ```bash
   composer install
   npm install
   ```

3. **Setup environment**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Configure Database** in your `.env` file.

5. **Run migrations & seed**
   ```bash
   php artisan migrate --seed --class=DemoSeeder
   # Creates admin@example.com / password
   ```

6. **Start developing**
   ```bash
   npm run dev
   php artisan serve
   ```

---

## 🤝 Contributing

Valero is open-source software. We welcome contributions! Please see our [Contributing Guide](docs/wiki/Contributing.md) for details.

## 📄 License

Valero is open-sourced software licensed under the [MIT license](LICENSE).

<div align="center">
  <sub>Made with ❤️ by <a href="https://github.com/zmeuldev">Zmeul Dev</a></sub>
</div>