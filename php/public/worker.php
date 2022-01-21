<?php

use App\Rpc\EchoService;
use PocMessaging\Protobuf\EchoServiceInterface;
use Spiral\Goridge\StreamRelay;
use Spiral\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/../vendor/autoload.php';

$server = new Server(null, [
    'debug' => false, // optional (default: false)
]);

$server->registerService(EchoServiceInterface::class, new EchoService());

$worker = \method_exists(Worker::class, 'create')
    // RoadRunner >= 2.x
    ? Worker::create()
    // RoadRunner 1.x
    : new Worker(new StreamRelay(STDIN, STDOUT))
;

$server->serve($worker);
