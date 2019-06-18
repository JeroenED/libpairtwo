.PHONY: help tests dist
.DEFAULT_GOAL := help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-12s\033[0m %s\n", $$1, $$2}'

tests: ## Executes the test suite
	vendor/bin/phpunit

coverage: ## Executes the test suite and creates code coverage reports
	vendor/bin/phpunit --coverage-html build/coverage

view-coverage: ## Shows the code coverage report
	open build/coverage/index.html

api: ## Generates api-docs
	wget -O vendor/bin/phpdoc http://www.phpdoc.org/phpDocumentor.phar
	chmod +x vendor/bin/phpdoc
	vendor/bin/phpdoc

dist: ## Generates distribution
	touch .libpairtwo-dist
	git add -A
	git commit -m "Commit before release"
	cp dist/composer* res/
	mv dist/composer-dist.json dist/composer.json
	cd dist && composer install
	rm dist/composer.json
	rm dist/composer.lock
	mv dist/composer-dist-installed.json dist/composer.json
	git reset --hard HEAD^
	wget -O vendor/bin/phpdoc http://www.phpdoc.org/phpDocumentor.phar
	chmod +x vendor/bin/phpdoc
	vendor/bin/phpdoc
	mkdir -p dist/doc
	cp -r doc/api dist/doc
	cd dist && zip -r ../libpairtwo-dist *
	mv res/composer* res/

cs: ## Fixes coding standard problems
	vendor/bin/php-cs-fixer fix || true

tag: ## Creates a new signed git tag
	$(if $(TAG),,$(error TAG is not defined. Pass via "make tag TAG=X.X.X"))
	@echo Tagging $(TAG)
	chag update $(TAG)
	git add --all
	git commit -m 'Release $(TAG)'
	git tag -s $(TAG) -m 'Release $(TAG)'
