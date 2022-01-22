# Makefile
#
# This file contains the commands most used in DEV, plus the ones used in CI and PRD environments.
#

# Execute targets as often as wanted
.PHONY: config

# Mute all `make` specific output. Comment this out to get some debug information.
.SILENT:

# make commands be run with `bash` instead of the default `sh`
SHELL='/bin/bash'

include Makefile.defaults.mk
ifneq ("$(wildcard Makefile.defaults.custom.mk)","")
  include Makefile.defaults.custom.mk
endif

# .DEFAULT: If the command does not exist in this makefile
# default: If no command was specified
.DEFAULT default:
	if [ -f ./Makefile.custom.mk ]; then \
	    $(MAKE) -f Makefile.custom.mk "$@"; \
	else \
	    if [ "$@" != "default" ]; then echo "Command '$@' not found."; fi; \
	    $(MAKE) help; \
	    if [ "$@" != "default" ]; then exit 2; fi; \
	fi

help:  ## Show this help
	@echo "Usage:"
	@echo "     ARG=VALUE ... make command"
	@echo "     make env-status"
	@echo "     NAMESPACE=\"dummy-app-namespace\" RELEASE_NAME=\"another-dummy-app\" make env-status"
	@echo
	@echo "Available commands:"
	@grep '^[^#[:space:]].*:' Makefile | grep -v '^default' | grep -v '^\.' | grep -v '=' | grep -v '^_' | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m  %-40s\033[0m %s\n", $$1, $$2}' | sed 's/://'

########################################################################################################################

setup: ## Prepare all projects to be run
	echo ""
	echo "==============================================="
	echo "===== Preparing the PHP project to be run"
	echo "==============================================="
	$(MAKE) .setup-composer
	$(MAKE) .install-dependencies

serve-grpc:
	./bin/rr-grpc serve -c ./config/.rr.grpc.yaml -v

start-consuming:
	./bin/console messenger:consume async

start-producing:
	./bin/console app:messaging:produce

.setup-composer: ## Setting up Composer, PHP's package manager
	echo ""
	echo "==============================================="
	echo "===== Setting up composer, PHP's package manager"
	echo "==============================================="
	mkdir -p ./var/
	curl -L https://getcomposer.org/download/${COMPOSER_VERSION}/composer.phar -o ${COMPOSER}
	chmod a+x ${COMPOSER}

.install-dependencies: ## Install PHP project dependencies
	echo ""
	echo "==============================================="
	echo "===== Setting up PHP project dependencies"
	echo "==============================================="
	${COMPOSER} install
