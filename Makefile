.PHONY: help tests dist
.DEFAULT_GOAL := help
BRANCH := $(shell git rev-parse --abbrev-ref HEAD)
VERSION := $(if $(TAG),$(TAG),dev-$(BRANCH))

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-12s\033[0m %s\n", $$1, $$2}'

tests: ## Executes the test suite
	vendor/bin/phpunit

coverage: ## Executes the test suite and creates code coverage reports
	vendor/bin/phpunit --coverage-html build/coverage

view-coverage: ## Shows the code coverage report
	open build/coverage/index.html

api: ## Generates api-docs
	VERSIONTAG=$(VERSION) doxygen

dist: ## Generates distribution
	cp dist/composer* res/
	mv dist/composer-dist.json dist/composer.json
	sed -i -e "s%//VERSION//%$(VERSION)%g" dist/composer.json
	cd dist && composer install
	rm dist/composer.json
	rm dist/composer.lock
	mv dist/composer-dist-installed.json dist/composer.json
	make api
	mkdir -p dist/doc
	cp -r doc/api dist/doc
	cd dist && zip -r ../libpairtwo-$(VERSION)-dist.zip *
	git reset --hard HEAD
	mv res/composer* dist/

clean: clean-dist clean-dev

clean-dev:
	rm -rf doc/api
	rm -rf .idea
	rm -rf .libpairtwo-distro
	rm -rf vendor
	rm -rf composer.lock

clean-dist:
	rm -rf dist/doc
	rm -rf dist/vendor
	rm -rf dist/composer.json
	rm -rf libpairtwo-*-dist.zip

cs: ## Fixes coding standard problems
	vendor/bin/php-cs-fixer fix || true

tag: ## Creates a new signed git tag
	$(if $(TAG),,$(error TAG is not defined. Pass via "make tag TAG=X.X.X"))
	@echo Tagging $(TAG)
	git add --all
	git commit -m 'RELEASE: $(TAG) Release'
	git tag -s $(TAG) -m 'RELEASE: $(TAG) Release'
	make dist
