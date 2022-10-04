.PHONY: it
it: coding-standards tests ## Runs the coding-standards and tests target

.PHONY: coding-standards
coding-standards: vendor ## Normalizes composer.json with ergebnis/composer-normalize and fixes code style issues with friendsofphp/php-cs-fixer
	composer normalize
	mkdir -p .build/php-cs-fixer
	vendor/bin/php-cs-fixer fix --config=.php_cs --diff --diff-format=udiff --verbose

.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: tests
tests: vendor ## Runs tests with phpunit/phpunit
	vendor/bin/phpunit --configuration=phpunit.xml.dist

vendor: composer.json composer.lock
	composer validate --strict
	composer install --no-interaction --no-progress
