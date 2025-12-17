# Valero Wiki Documentation

This directory contains the complete wiki documentation for Valero. These markdown files can be imported into GitHub's wiki or used as standalone documentation.

## 📁 Wiki Structure

### Getting Started
- **[Home](Home.md)** - Welcome page and overview
- **[Installation](Installation.md)** - Installation guide
- **[Configuration](Configuration.md)** - Configuration options
- **[First Steps](First-Steps.md)** - Quick start guide

### Features & Guides
- **[Features](Features.md)** - Complete features overview
- **[User Guide](User-Guide.md)** - End-user documentation
- **[Admin Guide](Admin-Guide.md)** - Administrator documentation

### Support
- **[FAQ](FAQ.md)** - Frequently asked questions
- **[Troubleshooting](Troubleshooting.md)** - Common issues and solutions
- **[Contributing](Contributing.md)** - How to contribute

### Reference
- **[Changelog](Changelog.md)** - Version history and updates

## 🚀 Setting Up GitHub Wiki

### Option 1: Manual Import

1. Enable wiki in your GitHub repository settings
2. Clone the wiki repository:
   ```bash
   git clone https://github.com/zmeuldev/valero.wiki.git
   ```
3. Copy files from `docs/wiki/` to the wiki repository
4. Commit and push:
   ```bash
   git add .
   git commit -m "Add wiki documentation"
   git push origin master
   ```

### Option 2: GitHub Web Interface

1. Go to your repository on GitHub
2. Click **Wiki** tab
3. Click **Create the first page**
4. Copy content from markdown files
5. Create pages manually

### Option 3: Use as Documentation Site

These files can also be used with:
- [MkDocs](https://www.mkdocs.org/)
- [GitBook](https://www.gitbook.com/)
- [Docusaurus](https://docusaurus.io/)
- [Jekyll](https://jekyllrb.com/)

## 📝 File Naming

GitHub wiki uses specific naming:
- `Home.md` - Main wiki page
- `Page-Name.md` - Other pages (spaces become hyphens)

## 🔗 Internal Links

Wiki pages link to each other using:
```markdown
[Link Text](Page-Name)
```

For GitHub wiki, ensure:
- File names match link targets
- Use hyphens, not underscores
- Case-sensitive matching

## ✏️ Editing

When editing wiki pages:
1. Keep formatting consistent
2. Update links if renaming pages
3. Test all links
4. Check spelling/grammar
5. Update related pages

## 📚 Additional Resources

- [GitHub Wiki Guide](https://docs.github.com/en/communities/documenting-your-project-with-wikis)
- [Markdown Guide](https://www.markdownguide.org/)
- [Valero Repository](https://github.com/zmeuldev/valero)

---

**Note:** Update links in pages to match your GitHub username if different from `zmeuldev`.

