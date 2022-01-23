<?php

namespace App\Rpc;

use PocMessaging\Protobuf\EchoServiceInterface;
use PocMessaging\Protobuf\Message;
use Spiral\RoadRunner\GRPC\ContextInterface;

class EchoService implements EchoServiceInterface
{
    public function ping(ContextInterface $ctx, Message $in): Message
    {
        $out = new Message();
        $out->setContent(strtoupper($in->getContent() . ' from the PHP gRPC server.'));
        $out->setSmallNumber($in->getSmallNumber() + 100);
        $out->setBigNumber($in->getBigNumber() + 100);

        return $out;
    }
}
