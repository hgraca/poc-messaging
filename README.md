# Messaging POC

This project is a POC for the integration between different platforms, using a Message Queue and, at some point, RPC.

At the moment, the different platforms are built using C#, C++, Rust and PHP.

All artifacts that relate to all projects should be placed at the root of the project, and artifacts related 
only to one of the languages, should be placed in the corresponding language.

## How to

Run `make setup` to prepare all sub-projects.

Run `make run` to run the POC.

Run `make` to see all other available commands.

### Start producing and consuming messages

#### PHP

After starting the POC with `make run`:

1. Open the kafka web UI to see the messages in the MQ at [http://localhost:8080/](http://localhost:8080/)
2. Login to the producer container and start producing messages:
   1. `make shell-php-producer`
   2. `./bin/console app:messaging:produce`
3. Login to the consumer and start consuming messages:
   1. `make shell-php-consumer`
   2. `./bin/console messenger:consume async`

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

### PHP

#### Install the PHP libraries

```
composer require "google/protobuf"
```

#### Generate the PHP code

```
./bin/protoc --php_out=php/lib/Protobuf ./idl/message.proto
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
