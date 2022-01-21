#!/usr/bin/env bash

# Generate the Certification Authority key and certificate
openssl genrsa -out ca.key 2048
openssl req -new -x509 -days 365 -key ca.key -subj "/C=CN/ST=GD/L=SZ/O=Acme, Inc./CN=Acme Root CA" -out ca.crt

# Generate the Certificate Signing Request, to be given to the Certification Authority
openssl req -newkey rsa:2048 -nodes -keyout server.key -subj "/C=CN/ST=GD/L=SZ/O=Acme, Inc./CN=*.localhost" -out server.csr

# Generate the self-signed Certificate
openssl x509 -req -extfile <(printf "subjectAltName=DNS:localhost,DNS:www.localhost") -days 365 -in server.csr -CA ca.crt -CAkey ca.key -CAcreateserial -out server.crt

# Convert the certificate to PEM format
openssl x509 -in server.crt -out server.pem -outform PEM
