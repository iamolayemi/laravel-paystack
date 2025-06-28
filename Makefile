.PHONY: help install test test-coverage analyse fix security-check clean build docs ci format check update update-lock validate dev-install dev-setup release-patch release-minor release-major docker-build docker-test docker-shell

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

install: ## Install dependencies
	composer install

test: ## Run tests
	vendor/bin/phpunit

test-coverage: ## Run tests with coverage report
	vendor/bin/phpunit --coverage-html coverage

analyse: ## Run static analysis with PHPStan
	vendor/bin/phpstan analyse

fix: ## Fix code style issues
	vendor/bin/pint

fix-dry-run: ## Check code style without fixing
	vendor/bin/pint --test

security-check: ## Check for security vulnerabilities
	vendor/bin/security-checker security:check composer.lock

clean: ## Clean build artifacts
	rm -rf coverage/
	rm -rf build/
	rm -rf vendor/

build: ## Build the package
	composer install --no-dev --optimize-autoloader

docs: ## Generate documentation
	@echo "Documentation is available at: https://laravel-paystack.netlify.app"

ci: ## Run all CI checks locally
	$(MAKE) test
	$(MAKE) analyse
	$(MAKE) fix-dry-run
	$(MAKE) security-check

format: ## Format all code
	$(MAKE) fix

check: ## Run all checks (test, analyse, format)
	$(MAKE) test
	$(MAKE) analyse
	$(MAKE) fix-dry-run

update: ## Update dependencies
	composer update

update-lock: ## Update composer.lock only
	composer update --lock

validate: ## Validate composer.json
	composer validate

# Development helpers
dev-install: ## Install development dependencies
	composer install --dev

dev-setup: ## Setup development environment
	$(MAKE) install
	$(MAKE) validate
	$(MAKE) check

# Release helpers
release-patch: ## Release patch version
	composer version patch

release-minor: ## Release minor version
	composer version minor

release-major: ## Release major version
	composer version major

# Docker helpers (if using Docker)
docker-build: ## Build Docker image
	docker build -t laravel-paystack .

docker-test: ## Run tests in Docker
	docker run --rm laravel-paystack make test

docker-shell: ## Run shell in Docker container
	docker run --rm -it laravel-paystack /bin/bash
