<?php
# Generated by the protocol buffer compiler.  DO NOT EDIT!
# source: service.proto

namespace GPBMetadata;

class Service
{
    public static $is_initialized = false;

    public static function initOnce() {
        $pool = \Google\Protobuf\Internal\DescriptorPool::getGeneratedPool();

        if (static::$is_initialized == true) {
          return;
        }
        \GPBMetadata\Message::initOnce();
        $pool->internalAddGeneratedFile(
            '
�
service.protoPocMessaging.Protobuf2W
EchoServiceH
ping.PocMessaging.Protobuf.Message.PocMessaging.Protobuf.Message" bproto3'
        , true);

        static::$is_initialized = true;
    }
}

