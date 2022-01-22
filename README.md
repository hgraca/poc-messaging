# Messaging POC

This project is a POC for the integration between different platforms, using a Message Queue and, at some point, RPC.

At the moment, the different platforms are built using C#, C++, Rust and PHP.

All artifacts that relate to all projects should be placed at the root of the project, and artifacts related 
only to one of the languages, should be placed in the corresponding language.

## How to

Run `make setup` to prepare all sub-projects.

If you make changes to the IDL files, generate the corresponding code with `make generate-protobuf-code`.

Run `make run` to run the POC.

Run `make` to see all other available commands.

### Start producing and consuming messages

#### PHP

After starting the POC with `make run`:

1. Open the kafka web UI to see the messages in the MQ at [http://localhost:8080/](http://localhost:8080/)
2. Open the gRPC web UI to send messages to the gRPC server at [http://localhost:8091/](http://localhost:8091/)
2. The HTTP server will be available at [http://localhost:9090/echoo](http://localhost:9090/echoo). You can post some text to it.
3. Login to the producer container and start producing messages:
   1. `make shell-php-producer`
   2. `make start-producing` # This will send 3 messages to the MQ, which will be consumed by the consumer applications
   3. `./bin/grpc_client.php some-message` # This will send 'some-message' to the gRPC server, which will reply with "SOME-MESSAGE ..."

## More info

### Protobuf

The main repository is [here](https://github.com/protocolbuffers/protobuf).

The documentation is [here](https://github.com/protocolbuffers/protobuf/tree/master/php).

[Protobuf 3 language guide](https://developers.google.com/protocol-buffers/docs/proto3)

#### The compiler can be found here:

Go [here](https://github.com/protocolbuffers/protobuf/releases) and download one of the releases, ie:
```
protoc-3.19.1-linux-*
protoc-3.19.1-osx-*
protoc-3.19.1-win*
```

Can be downloaded with:
```shell
make download-protobuf-compiler
```

#### Compiler plugin to generate the server code

The plugin `protoc-gen-php-grpc` can be found in the [spiral/php-grpc releases page](https://github.com/spiral/php-grpc/releases).
This plugin is required to generate a service server code for the application.

Can be downloaded with:
```shell
make download-protobuf-compiler-server-plugin
```

#### Build the compiler and the plugin to generate the service client code

Both the protobuf compiler and its plugins are part of the repository, 
nevertheless if we need to generate them again, here is the recipe. 

In the case of PHP, and probably other languages, the compiler needs a plugin which is not available for download, 
therefore we need to build it ourselves from the grpc repo, using bazel.

```shell
# Setup Bazel
# https://docs.bazel.build/versions/main/install-ubuntu.html#install-with-installer-ubuntu
BAZEL_VERSION='5.0.0'
curl -L https://github.com/bazelbuild/bazel/releases/download/${BAZEL_VERSION}/bazel-${BAZEL_VERSION}-installer-linux-x86_64.sh -o ./var/bazel-${BAZEL_VERSION}-installer-linux-x86_64.sh
./var/bazel-${BAZEL_VERSION}-installer-linux-x86_64.sh --user
export PATH="$PATH:$HOME/bin"
#apt install -y g++ unzip zip # might or might not be needed/desired

# Generate the protoc compiler and plugin
git clone --recurse-submodules git@github.com:grpc/grpc.git ./var/grpc
cd ./var/grpc
CC=/usr/bin/gcc bazel build @com_google_protobuf//:protoc //src/compiler:all
cd ../../

# Put the compiler and plugin in the main repo bin folder
cp bazel-bin/external/com_google_protobuf/protoc ./php/bin
cp bazel-bin/src/compiler/grpc_php_plugin ./php/bin
```

### PHP

#### Install the PHP libraries

```
composer require "google/protobuf"
```

#### Generate the PHP code

```shell
make generate-protobuf-code
```

#### Links of interest

[HOW TO SET UP RABBITMQ WITH DOCKER COMPOSE](https://x-team.com/blog/set-up-rabbitmq-with-docker-compose/)
[Guide to Setting Up Apache Kafka Using Docker](https://www.baeldung.com/ops/kafka-docker-setup)

[Symfony Messenger with custom serializer](https://blog.digital-craftsman.de/symfony-messenger-with-custom-serializer/)

[How do I install an extension of Kafka for PHP?](https://stackoverflow.com/questions/47676416/how-do-i-install-an-extension-of-kafka-for-php)
[PHP Kafka client - php-rdkafka](https://github.com/arnaud-lb/php-rdkafka)
[Kafka PHP: Produce and send a single message with headers](https://arnaud.le-blanc.net/php-rdkafka-doc/phpdoc/rdkafka-producertopic.producev.html)

[Enqueue's transport for Symfony Messenger component](https://github.com/sroze/messenger-enqueue-transport)
[EnqueueBundle. Quick tour.](https://github.com/php-enqueue/enqueue-dev/blob/master/docs/bundle/quick_tour.md)
[Kafka transport](https://github.com/php-enqueue/enqueue-dev/blob/master/docs/transport/kafka.md)
[Symfony Messenger with Apache Kafka as queue transport](https://stackoverflow.com/questions/58317692/symfony-messenger-with-apache-kafka-as-queue-transport)
[Messenger: Sync & Queued Message Handling](https://symfony.com/doc/current/messenger.html)

[UI for Apache Kafka – Free Web UI for Apache Kafka](https://github.com/provectus/kafka-ui)
[UI for Apache Kafka – Free Web UI for Apache Kafka: ENV variables](https://github.com/provectus/kafka-ui/blob/master/README.md#env_variables)

[RoadRunner gRPC](https://github.com/spiral/roadrunner-grpc)
