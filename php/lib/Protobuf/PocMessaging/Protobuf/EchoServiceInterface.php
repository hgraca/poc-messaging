<?php
# Generated by the protocol buffer compiler (spiral/php-grpc). DO NOT EDIT!
# source: service.proto

namespace PocMessaging\Protobuf;

use Spiral\GRPC;

interface EchoServiceInterface extends GRPC\ServiceInterface
{
    // GRPC specific service name.
    public const NAME = "PocMessaging.Protobuf.EchoService";

    /**
    * @param GRPC\ContextInterface $ctx
    * @param Message $in
    * @return Message
    *
    * @throws GRPC\Exception\InvokeException
    */
    public function ping(GRPC\ContextInterface $ctx, Message $in): Message;
}
