#!/usr/bin/env php
<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Message\Message;
use App\ProduceCommand;
use PocMessaging\Protobuf\EchoServiceClient;
use PocMessaging\Protobuf\Message as ProtobufMessage;

function grpc_echo($hostname, $textMessage)
{
    $client = new EchoServiceClient(
        $hostname,
        [
            'credentials' => Grpc\ChannelCredentials::createInsecure(),
        ]
    );
    $message = new Message(
        $textMessage,
        ProduceCommand::INT_32_LIMIT,
        ProduceCommand::INT_64_LIMIT
    );

    $protobufMessage = new ProtobufMessage();
    $protobufMessage->setContent($message->getContent());
    $protobufMessage->setSmallNumber((string) $message->getSmallNumber());
    $protobufMessage->setBigNumber((string) $message->getBigNumber());

    /** @var ProtobufMessage $response */
    /** @var stdClass $status {metadata: array, code: int, details: string}*/
    list($response, $status) = $client->ping($protobufMessage)->wait();
    if ($status->code !== Grpc\STATUS_OK) {
        echo "ERROR: " . $status->code . ", " . $status->details . PHP_EOL;
        exit(1);
    }
    echo $response->getContent() . PHP_EOL;
}

$textMessage = !empty($argv[1]) ? $argv[1] : 'Message from the PHP gRPC client';
$hostname = !empty($argv[2]) ? $argv[2] : 'php-grpc-server:50051';
grpc_echo($hostname, $textMessage);
