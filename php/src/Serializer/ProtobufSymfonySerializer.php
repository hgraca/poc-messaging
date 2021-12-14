<?php

declare(strict_types=1);

namespace App\Serializer;

use App\Message\Message;
use PocMessaging\Protobuf\Message as ProtobufMessage;
use Symfony\Component\Serializer\SerializerInterface as SymfonySerializerInterface;

final class ProtobufSymfonySerializer implements SymfonySerializerInterface
{
    public function serialize($data, string $format, array $context = [])
    {
        /** @var Message $data */

        $protobufMessage = new ProtobufMessage();
        $protobufMessage->setContent($data->getContent());

        $serializedString = $protobufMessage->serializeToString();

//        var_dump($data);
//        var_dump($serializedString);
//        die;
        return $serializedString;
    }

    public function deserialize($data, string $type, string $format, array $context = [])
    {
        $protobufMessage = new ProtobufMessage();
        $protobufMessage->mergeFromString($data);

        $message = new Message($protobufMessage->getContent());

        var_dump($data);
        var_dump($message);
        die;

        return $message;
    }
}
