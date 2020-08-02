.PHONY: help tests dist
.DEFAULT_GOAL := help
BRANCH := $(shell git rev-parse --abbrev-ref HEAD)
VERSION := $(if $(TAG),$(TAG),dev-$(BRANCH))

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-12s\033[0m %s\n", $$1, $$2}'

install-dev: ## Installs the required common devtools
	@echo "Downloading phpdoc"
	@wget https://phpdoc.org/phpDocumentor.phar -O bin/phpdoc 2> /dev/null
	@echo "Downloading phpcs"
	@wget https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar -O bin/phpcs 2> /dev/null
	@wget https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar -O bin/phpcbf 2> /dev/null
	@echo "Adding execution rights on the binaries"
	@chmod +x bin/phpcs bin/phpcbf bin/phpdoc
	@echo "Installation of devtools finished"
	@echo "Please add $(shell echo $(PWD))/bin to your PATH"

docs: ## Generates api-docs
	phpdoc -d ./src -t ./doc/api

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

clean: clean-dist clean-dev clean-repo ## Cleans all assets

clean-dev: ## Cleans dev assets
	rm -rf doc/api
	rm -rf .idea
	rm -rf .libpairtwo-distro
	rm -rf vendor
	rm -rf composer.lock

clean-dist: ## Cleans distribution assets
	rm -rf dist/doc
	rm -rf dist/vendor
	rm -rf dist/composer.json
	rm -rf libpairtwo-*-dist.zip

clean-repo: ## Cleans the git repository
	git fsck
	git prune
	git gc

cs: ## Fixes coding standard problems
	php bin/phpcs || true

tag: ## Creates a new signed git tag
	$(if $(TAG),,$(error TAG is not defined. Pass via "make tag TAG=X.X.X"))
	@echo Tagging $(TAG)
	git add --all
	git commit -m 'RELEASE: $(TAG) Release'
	git tag -s $(TAG) -m 'RELEASE: $(TAG) Release'
	make dist
