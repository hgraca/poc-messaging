# Messaging POC

This project is a POC for the integration between different platforms, using a Message Queue and, at some point, RPC.

At the moment, the different platforms are built using C#, C++, Rust and PHP.

All artifacts that relate to all projects should be placed at the root of the project, and artifacts related 
only to one of the languages, should be placed in the corresponding language.

## How to

Run `make setup` to prepare all sub-projects.

## More info

### Protobuf

The main repository is [here](https://github.com/protocolbuffers/protobuf).

The documentation is [here](https://github.com/protocolbuffers/protobuf/tree/master/php).

#### The compiler can be found here:

Go [here](https://github.com/protocolbuffers/protobuf/releases) and download one of the releases, ie:
```
protoc-3.19.1-linux-*
protoc-3.19.1-osx-*
protoc-3.19.1-win*
```

#### PHP

#### Install the PHP libraries

```
composer require "google/protobuf"
```

#### Generate the PHP code

```
./bin/protoc --php_out=src ./idl/protobuf/duration.proto
```
