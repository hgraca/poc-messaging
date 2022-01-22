# This file contains the default variables used in the Makefile
# If you want to change them, duplicate the file, name it "Makefile.defaults.custom.mk" and make the changes you want

CONTAINERS=php-producer php-consumer php-grpc-server php-grpc-ui zookeeper kafka kafka-ui # Service names from `docker-compose.yml`. Override this in "Makefile.defaults.custom.mk", for example to add 'redis worker'.
DOCKER_COMPOSE_ARGUMENTS= # Allows to add extra parameters or override configuration for docker-compose when called via make command. Override in in "Makefile.defaults.custom.mk"
DOCKER_NETWORK='poc-messaging-network'
HOST_IP="host.docker.internal" # For linux, override this in "Makefile.defaults.custom.mk" with "HOST_IP=`docker network inspect ${DOCKER_NETWORK} | grep Gateway | awk '{print $$2}' | tr -d '"'`"
HOST_USER_ID=`id -u` # This works for linux. If it doesnt work on your OS, create a "Makefile.defaults.custom.mk" file and place your host user ID there
PROJECT='poc-messaging'
PROTOC_VERSION='3.19.1'
PROTOC_PHP_VERSION='1.6.0'
ROADRUNNER_GRPC_VERSION='2.7.4'
