SHELL ?= /bin/bash
ARGS = $(filter-out $@,$(MAKECMDGOALS))

YELLOW=\033[0;33m
BLUE=\033[0;34m
BOLDGREEN=\033[1;32m

.SILENT: ;
.ONESHELL: ;
.NOTPARALLEL: ;
.EXPORT_ALL_VARIABLES: ;
Makefile: ;

.DEFAULT_GOAL := help

.PHONY: psr12-fix
psr12-fix:
	php vendor/bin/phpcbf --standard=psr12 src -n tests -n

.PHONY: psr12-check
psr12-check:
	php vendor/bin/phpcs --standard=psr12 src -n tests -n

.PHONY: psalm
psalm:
	php vendor/bin/psalm

.PHONY: install
install:
	composer install --dev

.PHONY: tests-build
tests-build:
	vendor/bin/codecept build

.PHONY: tests
tests: tests-build
	vendor/bin/codecept run

.PHONY: tests-coverage
tests-coverage:
	vendor/bin/codecept run --coverage-xml --xml


.PHONY: tests-run
tests-run: tests-build
	vendor/bin/codecept run ${ARGS}

.PHONY: default
default: help

.PHONY: help
help: .title
	printf '\n'
	printf "${BOLDGREEN}Available targets:${NC}\n"
	printf '\n'
	printf "${BLUE}make help${NC}:        ${YELLOW}Show this help${NC}\n"
	printf "${BLUE}make install${NC}:     ${YELLOW}Install composer dependencies${NC}\n"
	printf "${BLUE}make psr12-check${NC}: ${YELLOW}Check code in app and tests directory according PSR12 standards${NC}\n"
	printf "${BLUE}make psr12-fix${NC}:   ${YELLOW}Fix code in app and tests directory according PSR12 standards${NC}\n"
	printf "${BLUE}make psalm${NC}:       ${YELLOW}Check code in app directory via psalm${NC}\n"
	printf "${BLUE}make tests${NC}:       ${YELLOW}Run tests in tests container${NC}\n"
	printf "${BLUE}make tests-build${NC}: ${YELLOW}Run codecept build in app container${NC}\n"
	printf "${BLUE}make tests-run${NC}:   ${YELLOW}Run custom codecept test, for example: make tests-run {PATH_TO_FILE} ${NC}\n"
	printf '\n'

%:
	@:
