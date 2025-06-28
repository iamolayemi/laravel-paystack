# Development Guide

This guide covers the development workflow, available commands, and best practices for contributing to the Laravel Paystack package.

## 🚀 Quick Start

### Prerequisites

- **PHP**: ^8.1|^8.2|^8.3
- **Composer**: ^2.0
- **Git**: Latest version
- **Node.js**: ^16.0 (for documentation)

### Initial Setup

```bash
# Clone the repository
git clone https://github.com/iamolayemi/laravel-paystack.git
cd laravel-paystack

# Install dependencies
composer install

# Run complete setup
make dev-setup

# Verify everything works
make ci
```

## 📋 Available Commands

The project uses a comprehensive Makefile for all development tasks. Run `make help` to see all available commands.

### Essential Commands

| Command | Description |
|---------|-------------|
| `make help` | Show all available commands |
| `make install` | Install dependencies |
| `make dev-setup` | Complete development setup |
| `make dev-install` | Install development dependencies |

### Testing Commands

| Command | Description |
|---------|-------------|
| `make test` | Run all tests |
| `make test-coverage` | Run tests with coverage report |
| `vendor/bin/phpunit --filter=TestName` | Run specific test |
| `vendor/bin/phpunit tests/Unit/FileTest.php` | Run specific test file |

### Code Quality Commands

| Command | Description |
|---------|-------------|
| `make analyse` | Run PHPStan static analysis |
| `make fix` | Fix code style automatically |
| `make fix-dry-run` | Check code style without fixing |
| `make check` | Run all quality checks |

### CI/CD Commands

| Command | Description |
|---------|-------------|
| `make ci` | Run complete CI pipeline |
| `make security-check` | Check for security vulnerabilities |
| `make validate` | Validate composer.json |

### Maintenance Commands

| Command | Description |
|---------|-------------|
| `make clean` | Clean build artifacts |
| `make update` | Update dependencies |
| `make update-lock` | Update only composer.lock |
| `make build` | Build package for production |

### Release Commands

| Command | Description |
|---------|-------------|
| `make release-patch` | Release patch version (1.0.0 → 1.0.1) |
| `make release-minor` | Release minor version (1.0.0 → 1.1.0) |
| `make release-major` | Release major version (1.0.0 → 2.0.0) |

### Docker Commands (Optional)

| Command | Description |
|---------|-------------|
| `make docker-build` | Build Docker image |
| `make docker-test` | Run tests in Docker |
| `make docker-shell` | Run shell in Docker container |

## 🔄 Development Workflow

### 1. Setup Development Environment

```bash
# Clone and setup
git clone https://github.com/iamolayemi/laravel-paystack.git
cd laravel-paystack
make dev-setup
```

### 2. Create Feature Branch

```bash
# Update main branch
git fetch upstream
git checkout main
git merge upstream/main

# Create feature branch
git checkout -b feature/your-feature-name
```

### 3. Make Changes

```bash
# Edit files
# ... make your changes ...

# Run tests
make test

# Check code quality
make analyse

# Fix code style
make fix
```

### 4. Validate Changes

```bash
# Run complete validation
make ci

# If any issues, fix them and repeat
make fix
make test
make analyse
```

### 5. Commit and Push

```bash
# Add changes
git add .

# Commit with descriptive message
git commit -m "Add feature: description of changes"

# Push to your fork
git push origin feature/your-feature-name
```

### 6. Create Pull Request

- Go to GitHub and create a pull request
- Ensure all CI checks pass
- Request review from maintainers

## 🧪 Testing

### Running Tests

```bash
# Run all tests
make test

# Run with coverage (generates HTML report)
make test-coverage

# Run specific test suite
vendor/bin/phpunit --testsuite=Unit
vendor/bin/phpunit --testsuite=Feature

# Run with verbose output
vendor/bin/phpunit --verbose

# Run tests with stop on failure
vendor/bin/phpunit --stop-on-failure
```

### Writing Tests

All new features must include tests. Follow these guidelines:

- Place tests in the appropriate test directory
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

### Mock Testing

```php
use Illuminate\Support\Facades\Http;

Http::fake([
    'api.paystack.co/transaction/initialize' => Http::response([
        'status' => true,
        'message' => 'Authorization URL created',
        'data' => [
            'authorization_url' => 'https://checkout.paystack.com/0x234567',
            'reference' => 'TEST_REF_123',
        ],
    ], 200),
]);
```

## 📏 Code Quality

### Static Analysis

The project uses PHPStan for static analysis:

```bash
# Run PHPStan analysis
make analyse

# Run with specific level
vendor/bin/phpstan analyse --level=8

# Generate baseline (for ignoring existing errors)
vendor/bin/phpstan analyse --generate-baseline
```

### Code Style

The project uses Laravel Pint for code style enforcement:

```bash
# Fix all code style issues
make fix

# Check what would be fixed
make fix-dry-run

# Fix specific file
vendor/bin/pint src/Endpoints/Transaction.php
```

### Code Standards

- **PSR-12**: Coding standards
- **PHPStan Level 8**: Strict static analysis
- **Laravel Pint**: Code style enforcement
- **PHPUnit**: 100% test coverage target

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

## 🐛 Troubleshooting

### Common Issues

#### Tests Fail

```bash
# Clean and reinstall
make clean
composer install
make test
```

#### PHPStan Fails

```bash
# Check configuration
vendor/bin/phpstan analyse --debug

# Check specific file
vendor/bin/phpstan analyse src/YourFile.php
```

#### Style Check Fails

```bash
# Auto-fix style issues
make fix

# Check what would be fixed
make fix-dry-run
```

#### Dependencies Issues

```bash
# Update dependencies
make update

# Validate composer.json
make validate
```

### IDE Setup

For the best development experience:

1. **PHPStorm/IntelliJ**: Enable PHPStan integration
2. **VS Code**: Install PHP extensions
3. **EditorConfig**: Project includes `.editorconfig`
4. **PHP CS Fixer**: Configuration in `.php-cs-fixer.php`

### Pre-commit Hooks

Set up pre-commit hooks for automatic validation:

```bash
# Create pre-commit hook
cat > .git/hooks/pre-commit << 'EOF'
#!/bin/sh
make ci
EOF

chmod +x .git/hooks/pre-commit
```

## 📚 Additional Resources

- [Laravel Documentation](https://laravel.com/docs)
- [Paystack API Documentation](https://paystack.com/docs)
- [PHP Standards Recommendations](https://www.php-fig.org/psr/)
- [PHPUnit Documentation](https://phpunit.de/documentation.html)
- [PHPStan Documentation](https://phpstan.org/)
- [Laravel Pint Documentation](https://laravel.com/docs/pint)

## 🆘 Getting Help

If you need help:

1. **Check the documentation**: [README.md](../../README.md)
2. **Search existing issues**: [GitHub Issues](https://github.com/iamolayemi/laravel-paystack/issues)
3. **Create a new issue**: [GitHub Issues](https://github.com/iamolayemi/laravel-paystack/issues/new)

## 🎯 Best Practices

### Code Quality

- Write clean, readable code
- Follow PSR-12 standards
- Add proper type hints and docblocks
- Write comprehensive tests
- Keep functions small and focused

### Git Workflow

- Use descriptive commit messages
- Keep commits focused and atomic
- Use feature branches for new work
- Update documentation with changes

### Testing

- Write tests for all new features
- Use descriptive test names
- Follow AAA pattern (Arrange, Act, Assert)
- Mock external dependencies
- Aim for high test coverage

### Documentation

- Update README.md for user-facing changes
- Update inline documentation for code changes
- Keep examples up to date
- Document breaking changes

Happy coding! 🚀
