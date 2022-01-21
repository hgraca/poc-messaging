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
	echo "===== Preparing all projects to be run"
	echo "==============================================="
	$(MAKE) .container-create-network
	$(MAKE) build-containers
	DOCKER_USER_ID=${HOST_USER_ID} DOCKER_NETWORK=${DOCKER_NETWORK} HOST_IP=${HOST_IP} PROJECT=${PROJECT} docker compose -f ./build/container/docker-compose.yml ${DOCKER_COMPOSE_ARGUMENTS} run --entrypoint "sh -c 'cd php; make setup'" php-producer

build-containers: ## Build all containers needed for the project
	echo ""
	echo "==============================================="
	echo "===== Building all containers needed for the project"
	echo "==============================================="
	DOCKER_USER_ID=${HOST_USER_ID} DOCKER_NETWORK=${DOCKER_NETWORK} HOST_IP=${HOST_IP} PROJECT=${PROJECT} docker compose -f ./build/container/docker-compose.yml ${DOCKER_COMPOSE_ARGUMENTS} build

run: ## Start the application and keep it running and showing the logs
	cp -rf idl php/idl
	echo
	echo "ATTENTION: The PHP gRPC web UI will be available at http://localhost:8091/ if at all, NOT at http://0.0.0.0:8080/ despite what it reports back."
	echo
	DOCKER_USER_ID=${HOST_USER_ID} DOCKER_NETWORK=${DOCKER_NETWORK} HOST_IP=${HOST_IP} PROJECT=${PROJECT} docker compose -f ./build/container/docker-compose.yml ${DOCKER_COMPOSE_ARGUMENTS} up ${CONTAINERS}

shell-php-producer: ## Open a shell into the php container
	DOCKER_USER_ID=${HOST_USER_ID} DOCKER_NETWORK=${DOCKER_NETWORK} HOST_IP=${HOST_IP} PROJECT=${PROJECT} docker compose -f ./build/container/docker-compose.yml ${DOCKER_COMPOSE_ARGUMENTS} exec php-producer bash

shell-php-consumer: ## Open a shell into the php container
	DOCKER_USER_ID=${HOST_USER_ID} DOCKER_NETWORK=${DOCKER_NETWORK} HOST_IP=${HOST_IP} PROJECT=${PROJECT} docker compose -f ./build/container/docker-compose.yml ${DOCKER_COMPOSE_ARGUMENTS} exec php-consumer bash

shell-php-grpc-server: ## Open a shell into the php container
	DOCKER_USER_ID=${HOST_USER_ID} DOCKER_NETWORK=${DOCKER_NETWORK} HOST_IP=${HOST_IP} PROJECT=${PROJECT} docker compose -f ./build/container/docker-compose.yml ${DOCKER_COMPOSE_ARGUMENTS} exec php-grpc-server bash

download-protobuf-compiler: ## Download Protobuf compiler
	echo ""
	echo "==============================================="
	echo "===== Downloading and installing the protobuf compiler, project wide only"
	echo "==============================================="
	mkdir -p ./var/
	curl -L https://github.com/protocolbuffers/protobuf/releases/download/v${PROTOC_VERSION}/protoc-${PROTOC_VERSION}-linux-x86_64.zip -o ./var/protoc-${PROTOC_VERSION}-linux-x86_64.zip
	unzip ./var/protoc-${PROTOC_VERSION}-linux-x86_64.zip -d ./var/protoc-${PROTOC_VERSION}-linux-x86_64
	mkdir -p ./bin/
	mv ./var/protoc-${PROTOC_VERSION}-linux-x86_64/bin/protoc ./bin
	rm -rf ./var/protoc-${PROTOC_VERSION}-linux-x86_64

download-protobuf-compiler-server-plugin: ## Download Protobuf compiler server plugin
	echo ""
	echo "==============================================="
	echo "===== Downloading and installing the Spiral protobuf compiler PHP plugin. You need to make sure this plugin is in your PATH."
	echo "==============================================="
	mkdir -p ./var/
	curl -L https://github.com/spiral/php-grpc/releases/download/v${PROTOC_PHP_VERSION}/protoc-gen-php-grpc-${PROTOC_PHP_VERSION}-linux-amd64.tar.gz -o ./var/protoc-gen-php-grpc-${PROTOC_PHP_VERSION}-linux-amd64.tar.gz
	unzip ./var/protoc-gen-php-grpc-${PROTOC_PHP_VERSION}-linux-amd64.tar.gz -d ./var/protoc-gen-php-grpc-${PROTOC_PHP_VERSION}-linux-amd64
	mkdir -p ./bin/
	mv ./var/protoc-gen-php-grpc-${PROTOC_PHP_VERSION}-linux-amd64/protoc-gen-php-grpc ./bin
	rm -rf ./var/protoc-gen-php-grpc-${PROTOC_PHP_VERSION}-linux-amd64

download-rr-grpc: ## Download and install RoadRunner-GRPC
	echo ""
	echo "==============================================="
	echo "===== Downloading and installing RoadRunner-GRPC"
	echo "==============================================="
	mkdir -p ./var/
	curl -L https://github.com/spiral/php-grpc/releases/download/v${PROTOC_PHP_VERSION}/rr-grpc-${PROTOC_PHP_VERSION}-linux-amd64.tar.gz -o ./var/rr-grpc-${PROTOC_PHP_VERSION}-linux-amd64.tar.gz
	unzip ./var/rr-grpc-${PROTOC_PHP_VERSION}-linux-amd64.tar.gz -d ./var/rr-grpc-${PROTOC_PHP_VERSION}-linux-amd64
	mkdir -p ./bin/
	mv ./var/rr-grpc-${PROTOC_PHP_VERSION}-linux-amd64/rr-grpc ./php/bin
	rm -rf ./var/rr-grpc-${PROTOC_PHP_VERSION}-linux-amd64

generate-protobuf-code:
	echo "Generating PHP server services interfaces..."
	./bin/protoc --proto_path=./idl \
        --php_out=php/lib/Protobuf \
        --php-grpc_out=php/lib/Protobuf \
        --plugin=protoc-gen-grpc=bin/protoc-gen-php-grpc \
        ./idl/service.proto
	echo "Generating PHP DTOs and clients..."
	./bin/protoc --proto_path=./idl \
        --php_out=php/lib/Protobuf \
        --grpc_out=generate_server:php/lib/Protobuf \
        --plugin=protoc-gen-grpc=bin/grpc_php_plugin \
        ./idl/*
	cp -rf ./idl ./php/

.container-create-network: ## Create the container network to be used by this project container orchestration
	echo ""
	echo "==============================================="
	echo "===== Creating the container network"
	echo "==============================================="
	-docker network create ${DOCKER_NETWORK}
	docker network inspect ${DOCKER_NETWORK} | grep Gateway | awk '{print $$2}' | tr -d '"'
