.PHONY: help install test test-coverage analyse lint fix security-check update-deps clean

help: ## Show this help message
	@echo 'Usage: make [target]'
	@echo ''
	@echo 'Targets:'
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "  %-15s %s\n", $$1, $$2}' $(MAKEFILE_LIST)

install: ## Install dependencies
	composer install

test: ## Run tests
	composer test

test-coverage: ## Run tests with coverage
	composer test-coverage

analyse: ## Run static analysis
	composer analyse

lint: ## Check code style
	composer lint

fix: ## Fix code style
	composer fix

security-check: ## Check for security vulnerabilities
	composer security-check

update-deps: ## Update dependencies
	composer update
	composer audit

clean: ## Clean build artifacts
	rm -rf build/
	rm -rf coverage/
	rm -rf vendor/
	rm -f composer.lock

format: ## Format code with Laravel Pint
	composer format

ci: ## Run all CI checks
	composer test
	composer analyse
	composer lint
	composer security-check

prepare-release: ## Prepare for release
	composer test
	composer analyse
	composer lint
	composer security-check
	composer format
