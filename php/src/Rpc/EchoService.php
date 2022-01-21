<?php

namespace App\Rpc;

use PocMessaging\Protobuf\EchoServiceInterface;
use PocMessaging\Protobuf\Message;
use Spiral\GRPC\ContextInterface;

class EchoService implements EchoServiceInterface
{
    public function ping(ContextInterface $ctx, Message $in): Message
    {
        $out = new Message();
        $out->setContent(strtoupper($in->getContent() . ' from the PHP gRPC server.'));

        return $out;
    }
}
