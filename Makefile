phpunit: export XDEBUG_MODE=coverage
phpunit:
		@vendor/bin/phpunit
	
phpunitNoCov:
		@vendor/bin/phpunit --no-coverage

phpunitHtmlCov: export XDEBUG_MODE=coverage
phpunitHtmlCov:
		@vendor/bin/phpunit --coverage-html ./code-coverage