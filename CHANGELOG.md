# Changelog

All notable changes to `laravel-paystack` will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [Unreleased]

### Added
- Comprehensive exception handling with custom exception classes
- Input validation for API payloads
- Better type safety and return type declarations
- HTTP client improvements with retry logic and timeouts
- Environment detection methods (`isTestMode()`, `isLiveMode()`)
- Enhanced reference generation with better uniqueness
- Static analysis with PHPStan
- Code quality tools (PHP CS Fixer, Laravel Pint)
- Security vulnerability scanning
- Comprehensive CI/CD pipeline with GitHub Actions
- Better error handling with context information

### Changed
- Updated dependencies to latest secure versions
- Improved error messages and exception handling
- Enhanced HTTP client configuration
- Better code organization and structure
- Updated PHP version support to include 8.3

### Fixed
- Security vulnerabilities in dependencies
- Generic exception handling issues
- Missing return type declarations
- Inconsistent error handling patterns

### Security
- Updated all dependencies to patch security vulnerabilities
- Added security scanning to CI/CD pipeline
- Improved input validation and sanitization

## [1.0.0] - 2021-09-15

### Added
- Initial release
- Basic Paystack API integration
- Support for all major Paystack endpoints
- Laravel service provider and facade
- Basic documentation and examples
- Unit tests for all endpoints
