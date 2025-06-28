# Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- **Security Enhancements**
  - Added `enlightn/security-checker` for vulnerability scanning
  - Added `roave/security-advisories` for dependency security
  - Implemented comprehensive input validation
  - Added secret key format validation

- **Code Quality Tools**
  - Added PHPStan static analysis (Level 8)
  - Added PHP CS Fixer for code style enforcement
  - Added Laravel Pint for Laravel-specific formatting
  - Implemented comprehensive type safety

- **Exception Handling**
  - Created `PaystackException` base class with context support
  - Added `PaystackApiException` for API-specific errors
  - Added `PaystackConnectionException` for network errors
  - Added `PaystackValidationException` for validation errors

- **CI/CD Pipeline**
  - Added comprehensive GitHub Actions workflow
  - Multi-PHP version testing (8.1, 8.2, 8.3)
  - Multi-Laravel version testing (9, 10, 11)
  - Automated security scanning
  - Code quality checks

- **Development Tools**
  - Added comprehensive Makefile with development tasks
  - Added Docker support for containerized development
  - Added docker-compose.yml for easy setup
  - Added development environment configuration

- **Documentation**
  - Created advanced usage guide with best practices
  - Added comprehensive error handling documentation
  - Added security best practices guide
  - Enhanced README with detailed examples
  - Added troubleshooting guide

- **Core Improvements**
  - Enhanced base `Endpoint` class with better error handling
  - Improved main `Paystack` class with validation
  - Added response validation and error checking
  - Implemented retry logic with exponential backoff
  - Added connection pooling and optimization

### Changed
- **Dependencies**
  - Updated Guzzle HTTP to `^7.8` for security
  - Extended Laravel support to include Laravel 11
  - Added PHP 8.3 support
  - Updated all development dependencies to latest versions

- **Error Handling**
  - Replaced generic exception handling with specific exception types
  - Improved error context and logging
  - Enhanced API error response handling

- **Code Structure**
  - Made `Endpoint` class abstract for better inheritance
  - Improved method signatures with proper return types
  - Enhanced PHPDoc blocks throughout the codebase

### Fixed
- **Security Issues**
  - Fixed 7 security vulnerabilities in dependencies
  - Improved input validation and sanitization
  - Enhanced secret key validation

- **Code Quality**
  - Fixed type safety issues
  - Improved code consistency
  - Enhanced error handling patterns

### Removed
- Removed outdated dependency versions
- Removed generic exception handling
- Removed insecure default configurations

## [2.0.0] - 2024-01-15

### Added
- Support for Laravel 10
- Enhanced error handling
- Improved documentation
- Better test coverage

### Changed
- Updated minimum PHP version to 8.1
- Improved API response handling
- Enhanced facade implementation

### Fixed
- Various bug fixes and improvements

## [1.0.0] - 2023-01-01

### Added
- Initial release
- Basic Paystack API integration
- Transaction management
- Customer management
- Transfer functionality
- Basic error handling
- Laravel 9 support

---

## Migration Guide

### From 1.x to 2.x

#### Exception Handling Changes
```php
// Old way
try {
    $response = Paystack::transaction()->initialize($data);
} catch (Exception $e) {
    // Generic error handling
}

// New way
try {
    $response = Paystack::transaction()->initialize($data)->response();
} catch (PaystackApiException $e) {
    // Specific API error handling
} catch (PaystackValidationException $e) {
    // Validation error handling
}
```

#### Configuration Updates
```env
# Add new optional configuration
PAYSTACK_TIMEOUT=30
PAYSTACK_RETRY_ATTEMPTS=3
PAYSTACK_WEBHOOK_SECRET=whsec_xxxxxxxxxxxxxxxxxxxxx
```

### From 2.x to Unreleased

#### New Features
- Enhanced error handling with specific exception types
- Improved input validation
- Better security features
- Comprehensive development tools

#### Breaking Changes
- More specific exception classes
- Enhanced type safety
- Improved response handling methods

---

## Support

For support and questions:
- [GitHub Issues](https://github.com/iamolayemi/laravel-paystack/issues)
- [Documentation](https://laravel-paystack.netlify.app)
- [Security Issues](mailto:olatayo.olayemi.peter@gmail.com)
