#!/usr/bin/env bash

if [ "$CONTAINER_ROLE" == "consumer" ]; then
  make start-consuming
elif [ "$CONTAINER_ROLE" == "grpc-server" ]; then
  make serve-grpc
elif [ "$CONTAINER_ROLE" == "http-server" ]; then
  make serve-http
else
  sleep 60m
fi
