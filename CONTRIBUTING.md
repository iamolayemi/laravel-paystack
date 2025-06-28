# Contributing

Contributions are **welcome** and will be fully **credited**.

Please read and understand the contribution guide before creating an issue or pull request.

## 🚀 Quick Start

1. **Fork** the repository
2. **Clone** your fork: `git clone https://github.com/YOUR_USERNAME/laravel-paystack.git`
3. **Setup** development environment: `make dev-setup`
4. **Create** a feature branch: `git checkout -b feature/amazing-feature`
5. **Make** your changes
6. **Test** your changes: `make ci`
7. **Commit** your changes: `git commit -m "Add amazing feature"`
8. **Push** to your branch: `git push origin feature/amazing-feature`
9. **Open** a Pull Request

## 🔧 Development Setup

### Prerequisites

- **PHP**: ^8.1|^8.2|^8.3
- **Composer**: ^2.0
- **Git**: Latest version

### Installation

```bash
# Clone your fork
git clone https://github.com/YOUR_USERNAME/laravel-paystack.git
cd laravel-paystack

# Add upstream remote
git remote add upstream https://github.com/iamolayemi/laravel-paystack.git

# Install dependencies
make install

# Run complete setup
make dev-setup
```

### Development Workflow

```bash
# 1. Update your fork
git fetch upstream
git checkout main
git merge upstream/main

# 2. Create feature branch
git checkout -b feature/your-feature-name

# 3. Make your changes
# ... edit files ...

# 4. Run tests
make test

# 5. Check code quality
make analyse

# 6. Fix code style
make fix

# 7. Run complete validation
make ci

# 8. Commit your changes
git add .
git commit -m "Add feature: description"

# 9. Push to your fork
git push origin feature/your-feature-name
```

## 📋 Available Commands

The project uses a comprehensive Makefile for development tasks:

### Essential Commands

```bash
make help              # Show all available commands
make dev-setup         # Complete development setup
make test              # Run all tests
make analyse           # Run static analysis
make fix               # Fix code style
make ci                # Run complete CI pipeline
```

### Testing Commands

```bash
make test              # Run all tests
make test-coverage     # Run tests with coverage report
vendor/bin/phpunit --filter=TestName  # Run specific test
```

### Code Quality Commands

```bash
make analyse           # Run PHPStan static analysis
make fix               # Fix code style with Laravel Pint
make fix-dry-run       # Check code style without fixing
make check             # Run all quality checks
```

### Maintenance Commands

```bash
make clean             # Clean build artifacts
make update            # Update dependencies
make validate          # Validate composer.json
make security-check    # Check for vulnerabilities
```

## 🧪 Testing

### Running Tests

```bash
# Run all tests
make test

# Run with coverage
make test-coverage

# Run specific test file
vendor/bin/phpunit tests/Unit/TransactionEndpointTest.php

# Run with verbose output
vendor/bin/phpunit --verbose
```

### Writing Tests

- All new features must include tests
- Tests should be placed in the appropriate test directory
- Use descriptive test method names
- Follow the existing test patterns
- Aim for 100% test coverage

### Test Structure

```php
<?php

namespace Iamolayemi\Paystack\Tests\Unit;

use Iamolayemi\Paystack\Tests\TestCase;

class YourFeatureTest extends TestCase
{
    /** @test */
    public function it_should_do_something()
    {
        // Arrange
        $data = ['key' => 'value'];

        // Act
        $result = YourClass::method($data);

        // Assert
        $this->assertTrue($result);
    }
}
```

## 📏 Code Standards

### PHP Standards

- **PSR-12**: Coding standards
- **PHPStan Level 8**: Static analysis
- **Laravel Pint**: Code style enforcement

### Code Style

```bash
# Fix code style automatically
make fix

# Check code style
make fix-dry-run
```

### Static Analysis

```bash
# Run PHPStan analysis
make analyse

# Check specific file
vendor/bin/phpstan analyse src/YourFile.php
```

## 🔍 Code Review Checklist

Before submitting a pull request, ensure:

- [ ] All tests pass: `make test`
- [ ] Static analysis is clean: `make analyse`
- [ ] Code style is compliant: `make fix-dry-run`
- [ ] Security check passes: `make security-check`
- [ ] Complete CI pipeline passes: `make ci`
- [ ] Documentation is updated
- [ ] Commit messages are clear and descriptive
- [ ] Changes are focused and minimal

## 🐛 Bug Reports

When reporting bugs, please include:

1. **Environment details**: PHP version, Laravel version, package version
2. **Steps to reproduce**: Clear, step-by-step instructions
3. **Expected behavior**: What you expected to happen
4. **Actual behavior**: What actually happened
5. **Error messages**: Full error messages and stack traces
6. **Code examples**: Minimal code to reproduce the issue

## 💡 Feature Requests

When requesting features, please:

1. **Describe the problem**: What problem does this solve?
2. **Propose a solution**: How should it work?
3. **Consider alternatives**: Are there other ways to solve this?
4. **Provide examples**: Code examples of how it would be used

## 📝 Pull Request Guidelines

### Before Submitting

- [ ] Fork the repository
- [ ] Create a feature branch
- [ ] Make your changes
- [ ] Add tests for new functionality
- [ ] Ensure all tests pass
- [ ] Update documentation if needed
- [ ] Follow the coding standards

### Pull Request Template

```markdown
## Description
Brief description of the changes

## Type of Change
- [ ] Bug fix
- [ ] New feature
- [ ] Breaking change
- [ ] Documentation update

## Testing
- [ ] All tests pass
- [ ] New tests added
- [ ] Manual testing completed

## Checklist
- [ ] Code follows style guidelines
- [ ] Self-review completed
- [ ] Documentation updated
- [ ] No breaking changes (or documented)
```

## 🔄 Release Process

### Version Bumping

```bash
# Patch release (1.0.0 -> 1.0.1)
make release-patch

# Minor release (1.0.0 -> 1.1.0)
make release-minor

# Major release (1.0.0 -> 2.0.0)
make release-major
```

### Release Checklist

- [ ] All tests pass
- [ ] Documentation is updated
- [ ] CHANGELOG.md is updated
- [ ] Version is bumped
- [ ] Release notes are prepared

## 🤝 Community Guidelines

### Etiquette

This project is open source, and as such, the maintainers give their free time to build and maintain the source code
held within. They make the code freely available in the hope that it will be of use to other developers. It would be
extremely unfair for them to suffer abuse or anger for their hard work.

Please be considerate towards maintainers when raising issues or presenting pull requests. Let's show the
world that developers are civilized and selfless people.

It's the duty of the maintainer to ensure that all submissions to the project are of sufficient
quality to benefit the project. Many developers have different skillsets, strengths, and weaknesses. Respect the maintainer's decision, and do not be upset or abusive if your submission is not used.

### Communication

- Be respectful and constructive
- Use clear and descriptive language
- Provide context for your questions
- Be patient with responses

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Paystack API Documentation](https://paystack.com/docs)
- [PHP Standards Recommendations](https://www.php-fig.org/psr/)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)

## 🆘 Getting Help

If you need help:

1. **Check the documentation**: [README.md](README.md)
2. **Search existing issues**: [GitHub Issues](https://github.com/iamolayemi/laravel-paystack/issues)
3. **Create a new issue**: [GitHub Issues](https://github.com/iamolayemi/laravel-paystack/issues/new)

**Happy coding**! 🚀
