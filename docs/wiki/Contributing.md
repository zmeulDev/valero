# Contributing to Valero

Thank you for your interest in contributing to Valero! This guide will help you get started.

## 🤝 How to Contribute

### Reporting Bugs

1. Check if the bug has already been reported
2. Use the [Bug Report template](https://github.com/zmeuldev/valero/issues/new?template=bug_report.yml)
3. Include:
   - Clear description
   - Steps to reproduce
   - Expected vs actual behavior
   - Environment details
   - Screenshots if applicable

### Suggesting Features

1. Check if the feature has been requested
2. Use the [Feature Request template](https://github.com/zmeuldev/valero/issues/new?template=feature_request.yml)
3. Include:
   - Clear description
   - Problem it solves
   - Proposed solution
   - Use cases

### Code Contributions

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Write/update tests
5. Submit a pull request

## 🚀 Development Setup

### Prerequisites

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL 8.0+ or PostgreSQL 13+
- Git

### Setup Steps

```bash
# Clone your fork
git clone https://github.com/YOUR_USERNAME/valero.git
cd valero

# Add upstream remote
git remote add upstream https://github.com/zmeuldev/valero.git

# Install dependencies
composer install
npm install

# Copy environment file
cp .env.example .env

# Generate key
php artisan key:generate

# Run migrations
php artisan migrate

# Create storage link
php artisan storage:link

# Build assets
npm run dev
```

## 📝 Coding Standards

### PHP

- Follow [PSR-12](https://www.php-fig.org/psr/psr-12/) coding standard
- Use type hints
- Add docblocks for classes and methods
- Keep methods focused and small

### JavaScript

- Use ES6+ features
- Follow existing code style
- Use meaningful variable names
- Comment complex logic

### Blade Templates

- Use components when possible
- Keep templates clean and readable
- Use translation functions
- Follow existing naming conventions

## 🔀 Git Workflow

### Branch Naming

- `feature/description` - New features
- `bugfix/description` - Bug fixes
- `docs/description` - Documentation
- `refactor/description` - Code refactoring

### Commit Messages

Follow [Conventional Commits](https://www.conventionalcommits.org/):

```
type(scope): subject

body (optional)

footer (optional)
```

Types:
- `feat` - New feature
- `fix` - Bug fix
- `docs` - Documentation
- `style` - Formatting
- `refactor` - Code refactoring
- `test` - Tests
- `chore` - Maintenance

Examples:
```
feat(bookmarks): add category filtering
fix(media): prevent deletion of shared images
docs(readme): update installation instructions
```

### Pull Request Process

1. **Update your fork:**
   ```bash
   git fetch upstream
   git checkout main
   git merge upstream/main
   ```

2. **Create feature branch:**
   ```bash
   git checkout -b feature/your-feature
   ```

3. **Make changes and commit:**
   ```bash
   git add .
   git commit -m "feat(scope): description"
   ```

4. **Push to your fork:**
   ```bash
   git push origin feature/your-feature
   ```

5. **Create Pull Request:**
   - Use the PR template
   - Describe changes clearly
   - Link related issues
   - Add screenshots if UI changes

## ✅ Testing

### Running Tests

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test --filter TestName

# Run with coverage
php artisan test --coverage
```

### Writing Tests

- Write tests for new features
- Update tests for bug fixes
- Aim for good coverage
- Test edge cases

## 📚 Documentation

### Code Documentation

- Add docblocks to classes and methods
- Document complex logic
- Update README if needed
- Update wiki if applicable

### Translation

When adding new strings:
1. Add to `resources/lang/en/`
2. Add to `resources/lang/ro/`
3. Add to `resources/lang/es/`

## 🎨 UI/UX Guidelines

### Design Principles

- Follow existing design patterns
- Maintain consistency
- Ensure accessibility
- Test on multiple devices
- Support dark mode

### Components

- Use existing components when possible
- Create reusable components
- Follow Tailwind CSS patterns
- Use Lucide icons

## 🔍 Code Review

### Before Submitting

- [ ] Code follows style guide
- [ ] Tests pass
- [ ] No console errors
- [ ] Documentation updated
- [ ] Translations added
- [ ] Works in dark mode
- [ ] Mobile responsive

### Review Process

1. Maintainers review PRs
2. Address feedback
3. Make requested changes
4. PR is merged when approved

## 🐛 Bug Fixes

### Process

1. Identify the bug
2. Create issue (if not exists)
3. Fix the bug
4. Add test case
5. Submit PR

### Priority

- Security issues - Highest
- Data loss bugs - High
- Feature bugs - Medium
- UI/UX issues - Low

## ✨ Feature Development

### Process

1. Discuss in issue first
2. Get approval
3. Implement feature
4. Write tests
5. Update documentation
6. Submit PR

### Considerations

- Backward compatibility
- Database migrations
- Configuration options
- Performance impact
- Security implications

## 📖 Documentation Contributions

### Types

- Wiki pages
- Code comments
- README updates
- API documentation
- Tutorials

### Guidelines

- Clear and concise
- Use examples
- Keep updated
- Check spelling/grammar

## 🎯 Areas for Contribution

### High Priority

- Bug fixes
- Security improvements
- Performance optimization
- Documentation
- Test coverage

### Medium Priority

- New features (discuss first)
- UI/UX improvements
- Code refactoring
- Translation improvements

### Low Priority

- Code style improvements
- Minor UI tweaks
- Documentation updates

## 💡 Ideas & Suggestions

Have an idea? Great!

1. Check existing issues
2. Create feature request
3. Discuss with maintainers
4. Get feedback
5. Implement if approved

## 🏆 Recognition

Contributors are recognized in:
- README.md
- Release notes
- GitHub contributors page

## 📞 Questions?

- Open a [Discussion](https://github.com/zmeuldev/valero/discussions)
- Check [FAQ](FAQ)
- Review existing issues

## 📜 License

By contributing, you agree that your contributions will be licensed under the MIT License.

---

**Thank you for contributing to Valero!** 🎉

