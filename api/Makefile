vendor: composer.json composer.lock
	@composer install --no-interaction

clear:
	@php bin/console doctrine:cache:clear-metadata --no-debug
	@php bin/console cache:clear --env=dev --no-debug
	@php bin/console cache:clear --env=prod --no-debug
	@php bin/console doctrine:cache:clear-query --no-debug
	@php bin/console doctrine:cache:clear-result --no-debug

db:
	@php bin/console doctrine:database:drop --if-exists --force
	@php bin/console doctrine:database:create --if-not-exists
	@php bin/console doctrine:database:drop --if-exists --env=test --force
	@php bin/console doctrine:database:create --if-not-exists --env=test
	@php bin/console doctrine:fixtures:load --no-interaction
	@php bin/console doctrine:fixtures:load --no-interaction --env=test

cs:
	@composer cs-fixer

analyse:
	@composer phpstan

lint-yaml:
	@php bin/console lint:yaml config/ src/ --parse-tags

test:
	@composer test

all: cs analyse test