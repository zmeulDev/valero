# Changelog

All notable changes to Valero will be documented in this file.

## [Unreleased]

### Planned
- Enhanced user roles and permissions
- Social login integration
- Advanced analytics dashboard
- Comments system
- WebP image conversion
- CDN integration

## [0.42293] - December 2025

### Added
- ✨ **Bookmarking System** - Complete bookmark management with categories, search, and article integration
- ✨ **Media Library Reuse** - Reuse existing images when creating/editing articles
- ✨ **Reference Counting** - Smart image deletion that preserves shared images across articles
- ✨ **Modern Auth UI** - Complete redesign of authentication views with dark mode
- ✨ **JavaScript Refactoring** - Centralized admin and frontend JavaScript files
- ✨ **Enhanced External Links UI** - Platform-specific cards for YouTube, Instagram, and Local Store links
- ✨ **Bookmarks Pagination** - Efficient pagination for bookmarks library in article options tab

### Changed
- 🎨 **Bookmarks Index UI** - Redesigned with modern card-based layout (10 items per page)
- 🔄 **Article Options Tab** - Enhanced bookmarks library with search, filters, and pagination
- 🌐 **Translation Updates** - Added complete translations for bookmarking feature (EN, RO, ES)

### Fixed
- 🐛 Fixed bookmark category saving (`__new__` issue)
- 🐛 Fixed clipboard copy functionality for HTTP environments
- 🐛 Fixed media library image attachment on article creation
- 🐛 Fixed translation keys and duplicate keys in language files

## [0.4] - December 2025

### Added
- ✨ **Dynamic SEO Management** - Admin panel for meta tags, Open Graph, and keywords
- ✨ **Enhanced Gallery System** - Modern modal with zoom, fullscreen, download, thumbnails
- ✨ **Image Processing** - ICC color profile preservation, .jpeg→.jpg normalization
- ✨ **View Structure Refactoring** - Laravel naming conventions, organized components
- ✨ **Smart Paste Handler** - TinyMCE preserves lists, formatting, and indentation
- ✨ **AJAX Image Management** - Set cover and delete without page reload
- ✨ **Touch Gestures** - Swipe support for mobile gallery navigation
- ✨ **Image Preloading** - Adjacent images preload for smooth navigation
- ✨ **Settings API** - Centralized settings with app_ prefix in database
- ✨ **Toast System** - Global notification system with color-coded types

### Changed
- 🎨 Improved admin UI consistency
- 🔄 Optimized image handling
- 📝 Enhanced documentation

### Fixed
- 🐛 Image upload validation
- 🐛 Dimension display
- 🐛 File size calculation

## [0.3] - November 2025

### Added
- ✨ **Article Preview System** - Preview scheduled articles before publishing
- ✨ **Scheduled Articles Calendar** - Visual calendar view for scheduled content
- ✨ **Device Toggle** - Desktop/tablet/mobile preview modes
- ✨ **Related Articles** - Modern 3-column layout for related content

### Changed
- 🎨 Enhanced article management interface
- 🔄 Improved scheduled articles workflow

## [0.2] - October 2025

### Added
- ✨ **Media Library** - Enhanced grid view with metadata
- ✨ **Category Management** - Full CRUD for categories
- ✨ **User Authentication** - Registration, login, password reset
- ✨ **Admin Dashboard** - Statistics and overview

### Changed
- 🎨 Improved UI/UX
- 🔄 Enhanced performance

## [0.1] - September 2025

### Added
- ✨ Initial release
- ✨ Basic article management
- ✨ Image uploads
- ✨ Rich text editor
- ✨ Basic admin panel

---

**Legend:**
- ✨ Added
- 🎨 Changed
- 🐛 Fixed
- 🔒 Security
- 🗑️ Removed
- 📝 Documentation

