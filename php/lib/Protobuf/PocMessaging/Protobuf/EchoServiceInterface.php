<?php
# Generated by the protocol buffer compiler (spiral/php-grpc). DO NOT EDIT!
# source: service.proto

namespace PocMessaging\Protobuf;

use Spiral\RoadRunner\GRPC\ContextInterface;
use Spiral\RoadRunner\GRPC\Exception\InvokeException;
use Spiral\RoadRunner\GRPC\ServiceInterface;

interface EchoServiceInterface extends ServiceInterface
{
    // GRPC specific service name.
    public const NAME = "PocMessaging.Protobuf.EchoService";

    /**
    * @param ContextInterface $ctx
    * @param Message $in
    * @return Message
    *
    * @throws InvokeException
    */
    public function ping(ContextInterface $ctx, Message $in): Message;
}
