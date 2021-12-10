<?php

declare(strict_types=1);

namespace App\Message;

use App\AsyncMessageInterface;

final class Message implements AsyncMessageInterface
{
    private $content;

    public function __construct(string $content)
    {
        $this->content = $content;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
