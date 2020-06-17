.PHONY: it
it: tests ## Runs the tests target

.PHONY: help
help: ## Displays this list of targets with descriptions
	@grep -E '^[a-zA-Z0-9_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}'

.PHONY: tests
tests: vendor ## Runs tests with phpunit/phpunit
	vendor/bin/phpunit --configuration=phpunit.xml.dist

vendor: composer.json composer.lock
	composer validate --strict
	composer install --no-interaction --no-progress --no-suggest
