<?php

use App\Kernel;
use PocMessaging\Protobuf\EchoServiceInterface;
use Spiral\RoadRunner\GRPC\Server;
use Spiral\RoadRunner\Worker;

require __DIR__ . '/../vendor/autoload.php';

$server = new Server(null, [
    'debug' => false, // optional (default: false)
]);

$symfonyKernel = new Kernel('dev', false);
$symfonyKernel->boot();

$serviceId = EchoServiceInterface::class;
$server->registerService(
    $serviceId,
    $symfonyKernel->getContainer()->get($serviceId)
);

$server->serve(Worker::create());
