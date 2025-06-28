# Laravel Paystack

[![Latest Version on Packagist](https://img.shields.io/packagist/v/iamolayemi/laravel-paystack.svg?style=flat-square)](https://packagist.org/packages/iamolayemi/laravel-paystack)
[![Total Downloads](https://img.shields.io/packagist/dt/iamolayemi/laravel-paystack.svg?style=flat-square)](https://packagist.org/packages/iamolayemi/laravel-paystack)
[![Build Status](https://img.shields.io/github/actions/workflow/status/iamolayemi/laravel-paystack/ci.yml?branch=main)](https://github.com/iamolayemi/laravel-paystack/actions)
[![Code Quality](https://img.shields.io/scrutinizer/g/iamolayemi/laravel-paystack.svg?style=flat-square)](https://scrutinizer-ci.com/g/iamolayemi/laravel-paystack)
[![Code Coverage](https://img.shields.io/codecov/c/github/iamolayemi/laravel-paystack)](https://codecov.io/gh/iamolayemi/laravel-paystack)
[![PHP Version](https://img.shields.io/packagist/php-v/iamolayemi/laravel-paystack.svg?style=flat-square)](https://php.net)
[![License](https://img.shields.io/packagist/l/iamolayemi/laravel-paystack.svg?style=flat-square)](https://github.com/iamolayemi/laravel-paystack/blob/main/LICENSE.md)

A comprehensive Laravel package for seamless integration with the Paystack payment gateway. This package provides an expressive and convenient way to interact with the Paystack API within your Laravel application.

## ✨ Features

- 🚀 **Fluent API Interface** - Clean and intuitive method chaining
- 🛡️ **Comprehensive Error Handling** - Custom exception classes for different error types
- 🔒 **Security First** - Built-in validation and security checks
- 📊 **Full API Coverage** - Support for all Paystack API endpoints
- 🧪 **Extensive Testing** - High test coverage with mock support
- 📚 **Excellent Documentation** - Comprehensive guides and examples
- 🔧 **Developer Friendly** - Easy setup and configuration
- ⚡ **Performance Optimized** - Efficient HTTP client with retry logic
- 🌍 **Multi-Currency Support** - NGN, GHS, USD, and more
- 🔄 **Webhook Support** - Built-in webhook handling and verification

## 📋 Requirements

- **PHP**: ^8.1|^8.2|^8.3
- **Laravel**: ^9.0|^10.0|^11.0
- **Composer**: ^2.0

## 🚀 Installation

You can install the package via Composer:

```bash
composer require iamolayemi/laravel-paystack
```

The package will automatically register itself if you're using Laravel's auto-discovery feature.

## ⚙️ Configuration

### Environment Variables

Add your Paystack credentials to your `.env` file:

```env
PAYSTACK_SECRET_KEY=sk_test_xxxxxxxxxxxxxxxxxxxxx
PAYSTACK_PUBLIC_KEY=pk_test_xxxxxxxxxxxxxxxxxxxxx
PAYSTACK_CALLBACK_URL=https://yourdomain.com/paystack/callback
PAYSTACK_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxxx
```

### Publishing Configuration (Optional)

```bash
php artisan vendor:publish --provider="Iamolayemi\Paystack\PaystackServiceProvider"
```

## 📖 Quick Start

### Basic Usage

```php
use Iamolayemi\Paystack\Facades\Paystack;

// Initialize a payment
$paymentData = [
    'amount' => 500000, // 5000 NGN in kobo
    'email' => 'customer@example.com',
    'reference' => 'PAY_' . uniqid(),
    'callback_url' => 'https://yourdomain.com/payment/callback',
];

$response = Paystack::transaction()
    ->initialize($paymentData)
    ->response();

if ($response['status']) {
    $authorizationUrl = $response['data']['authorization_url'];
    // Redirect user to $authorizationUrl
}
```

### Using Helper Function

```php
// Using the helper function
$response = paystack()->transaction()
    ->initialize($paymentData)
    ->response();
```

### Getting Specific Data

```php
// Get only the authorization URL
$authorizationUrl = Paystack::transaction()
    ->initialize($paymentData)
    ->response('data.authorization_url');

// Or use the dedicated method
$authorizationUrl = Paystack::transaction()
    ->initialize($paymentData)
    ->authorizationURL();
```

### Verifying Transactions

```php
// Verify a transaction
$reference = 'PAY_xxxxxxxxx';
$verification = Paystack::transaction()
    ->verify($reference)
    ->response();

if ($verification['status'] && $verification['data']['status'] === 'success') {
    // Payment was successful
    $amount = $verification['data']['amount'];
    $customerEmail = $verification['data']['customer']['email'];
}
```

## 🔧 Available Endpoints

The package provides access to all Paystack API endpoints:

### Transactions
```php
Paystack::transaction()->initialize($data);
Paystack::transaction()->verify($reference);
Paystack::transaction()->list($params);
Paystack::transaction()->fetch($id);
```

### Customers
```php
Paystack::customer()->create($data);
Paystack::customer()->list($params);
Paystack::customer()->fetch($emailOrCode);
Paystack::customer()->update($code, $data);
```

### Transfers
```php
Paystack::transfer()->initiate($data);
Paystack::transfer()->finalize($data);
Paystack::transfer()->list($params);
Paystack::transfer()->fetch($code);
```

### Plans & Subscriptions
```php
Paystack::plan()->create($data);
Paystack::plan()->list($params);
Paystack::subscription()->create($data);
Paystack::subscription()->list($params);
```

### And Many More...
- **Banks**: List banks, resolve account numbers
- **Countries**: List countries and states
- **Invoices**: Create and manage invoices
- **Products**: Product management
- **Refunds**: Process refunds
- **Settlements**: Settlement management
- **Splits**: Split payment configuration
- **Sub-accounts**: Sub-account management

## 🛡️ Error Handling

The package provides comprehensive error handling with custom exception classes:

```php
use Iamolayemi\Paystack\Exceptions\PaystackApiException;
use Iamolayemi\Paystack\Exceptions\PaystackValidationException;
use Iamolayemi\Paystack\Exceptions\PaystackConnectionException;

try {
    $response = Paystack::transaction()->initialize($data)->response();
} catch (PaystackValidationException $e) {
    // Handle validation errors
    $errors = $e->getErrors();
} catch (PaystackApiException $e) {
    // Handle API errors
    $message = $e->getMessage();
    $endpoint = $e->getEndpoint();
} catch (PaystackConnectionException $e) {
    // Handle connection errors
    $url = $e->getUrl();
}
```

## 🧪 Testing

### Running Tests

```bash
# Run all tests
composer test

# Run with coverage
composer test-coverage

# Run specific test
vendor/bin/phpunit --filter=TransactionTest
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

## 📚 Documentation

For detailed documentation, visit [https://laravel-paystack.netlify.app](https://laravel-paystack.netlify.app)

### Additional Resources

- [Advanced Usage Guide](docs/src/guide/advanced-usage.md)
- [API Reference](docs/src/endpoints.md)
- [Testing Guide](docs/src/guide/testing.md)
- [Security Best Practices](docs/src/guide/security.md)

## 🔧 Development

### Prerequisites

- **PHP**: ^8.1|^8.2|^8.3
- **Composer**: ^2.0
- **Node.js**: ^16.0 (for documentation)

### Quick Setup

```bash
# Clone the repository
git clone https://github.com/iamolayemi/laravel-paystack.git
cd laravel-paystack

# Install dependencies
composer install

# Run all checks to ensure everything is working
make ci
```

### Available Commands

The project uses a comprehensive Makefile for development tasks:

```bash
# Show all available commands
make help

# Install dependencies
make install

# Development workflow
make dev-setup          # Complete development setup
make dev-install        # Install development dependencies
```

#### Testing Commands

```bash
# Run all tests
make test

# Run tests with coverage report
make test-coverage

# Run specific test file
vendor/bin/phpunit tests/Unit/TransactionEndpointTest.php

# Run tests with specific filter
vendor/bin/phpunit --filter=testTransactionInitialization
```

#### Code Quality Commands

```bash
# Run static analysis with PHPStan
make analyse

# Fix code style issues automatically
make fix

# Check code style without fixing
make fix-dry-run

# Run all code quality checks
make check
```

#### Security & Validation

```bash
# Check for security vulnerabilities
make security-check

# Validate composer.json
make validate
```

#### CI/CD Commands

```bash
# Run complete CI pipeline (test + analyse + style + security)
make ci

# Run all checks (test + analyse + style)
make check
```

#### Maintenance Commands

```bash
# Clean build artifacts
make clean

# Update dependencies
make update

# Update only composer.lock
make update-lock

# Build the package for production
make build
```

#### Documentation Commands

```bash
# Generate documentation
make docs

# Build documentation (if using docs package)
cd docs && npm install && npm run build
```

#### Docker Commands (Optional)

```bash
# Build Docker image
make docker-build

# Run tests in Docker
make docker-test

# Run shell in Docker container
make docker-shell
```

#### Release Commands

```bash
# Release patch version (1.0.0 -> 1.0.1)
make release-patch

# Release minor version (1.0.0 -> 1.1.0)
make release-minor

# Release major version (1.0.0 -> 2.0.0)
make release-major
```

### Development Workflow

1. **Setup**: `make dev-setup`
2. **Make changes**: Edit code
3. **Test**: `make test`
4. **Check quality**: `make analyse`
5. **Fix style**: `make fix`
6. **Full validation**: `make ci`
7. **Commit**: `git commit -m "Your message"`
8. **Push**: `git push`

### Code Quality Standards

The project enforces high code quality standards:

- **PHPStan Level 8**: Strict static analysis
- **Laravel Pint**: PSR-12 coding standards
- **PHPUnit**: 100% test coverage target
- **Security Checker**: Vulnerability scanning

### Testing Strategy

```bash
# Run all tests
make test

# Run with coverage (generates HTML report)
make test-coverage

# Run specific test suite
vendor/bin/phpunit --testsuite=Unit
vendor/bin/phpunit --testsuite=Feature

# Run tests with verbose output
vendor/bin/phpunit --verbose

# Run tests with stop on failure
vendor/bin/phpunit --stop-on-failure
```

### Static Analysis

```bash
# Run PHPStan analysis
make analyse

# Run with specific level
vendor/bin/phpstan analyse --level=8

# Generate baseline (for ignoring existing errors)
vendor/bin/phpstan analyse --generate-baseline
```

### Code Style

```bash
# Fix all code style issues
make fix

# Check what would be fixed
make fix-dry-run

# Fix specific file
vendor/bin/pint src/Endpoints/Transaction.php
```

### Troubleshooting

```bash
# If tests fail, try cleaning and reinstalling
make clean
composer install
make test

# If PHPStan fails, check configuration
vendor/bin/phpstan analyse --debug

# If style check fails, auto-fix
make fix
```

### IDE Setup

For the best development experience:

1. **PHPStorm/IntelliJ**: Enable PHPStan integration
2. **VS Code**: Install PHP extensions
3. **EditorConfig**: Project includes `.editorconfig`
4. **PHP CS Fixer**: Configuration in `.php-cs-fixer.php`

### Pre-commit Hooks

Consider setting up pre-commit hooks:

```bash
# Create pre-commit hook
cat > .git/hooks/pre-commit << 'EOF'
#!/bin/sh
make ci
EOF

chmod +x .git/hooks/pre-commit
```

## 🤝 Contributing

We welcome contributions! Please see our [Contributing Guide](CONTRIBUTING.md) for details.

### Development Setup

1. Fork the repository
2. Clone your fork
3. Install dependencies: `composer install`
4. Run tests: `make test`
5. Make your changes
6. Ensure all tests pass: `make ci`
7. Submit a pull request

## 🐛 Bug Reports

If you discover any bugs, please create an issue on [GitHub](https://github.com/iamolayemi/laravel-paystack/issues).

## 🔒 Security

If you discover any security-related issues, please email [olatayo.olayemi.peter@gmail.com](mailto:olatayo.olayemi.peter@gmail.com) instead of using the issue tracker.

## 📄 License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## 🙏 Credits

- [Olayemi Olatayo](https://github.com/iamolayemi) - Original author
- [All Contributors](../../contributors) - Community contributors
- [Paystack](https://paystack.com) - Payment gateway provider

## 🔗 Links

- [Paystack API Documentation](https://paystack.com/docs)
- [Laravel Documentation](https://laravel.com/docs)
- [Package on Packagist](https://packagist.org/packages/iamolayemi/laravel-paystack)
- [GitHub Repository](https://github.com/iamolayemi/laravel-paystack)

## 📊 Statistics

- **Downloads**: [![Total Downloads](https://img.shields.io/packagist/dt/iamolayemi/laravel-paystack.svg?style=flat-square)](https://packagist.org/packages/iamolayemi/laravel-paystack)
- **Stars**: [![GitHub stars](https://img.shields.io/github/stars/iamolayemi/laravel-paystack.svg?style=flat-square)](https://github.com/iamolayemi/laravel-paystack)
- **Forks**: [![GitHub forks](https://img.shields.io/github/forks/iamolayemi/laravel-paystack.svg?style=flat-square)](https://github.com/iamolayemi/laravel-paystack)
