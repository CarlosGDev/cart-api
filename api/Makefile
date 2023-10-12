vendor: composer.json composer.lock
	@composer install --no-interaction

clear:
	@php bin/console cache:pool:clear cache.global_clearer

load-fixtures:
	@php bin/console doctrine:database:drop --force
	@php bin/console doctrine:database:create
	@php bin/console doctrine:database:drop --env=test --force
	@php bin/console doctrine:database:create --env=test
	@php bin/console doctrine:schema:create
	@php bin/console doctrine:schema:create --env=test
	@php bin/console doctrine:fixtures:load -n
	@php bin/console doctrine:fixtures:load -n --env=test

cs:
	@composer cs-fixer

analyse:
	@composer phpstan

lint-yaml:
	@php bin/console lint:yaml config/ src/ --parse-tags

test:
	@composer test

all: cs analyse test