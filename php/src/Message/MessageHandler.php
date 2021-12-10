<?php

declare(strict_types=1);

namespace App\Message;

use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class MessageHandler implements MessageHandlerInterface
{
    public function __invoke(Message $message)
    {
        echo $message->getContent() . "\n\n";
    }
}
