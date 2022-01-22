<?php

use App\Rpc\EchoService;
use PocMessaging\Protobuf\EchoServiceInterface;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/../vendor/autoload.php';

$server = new Server(null, [
    'debug' => false, // optional (default: false)
]);

$server->registerService(EchoServiceInterface::class, new EchoService());

$server->serve(Worker::create());
