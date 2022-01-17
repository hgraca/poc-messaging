<?php

declare(strict_types=1);

namespace App\Message;

use App\AsyncMessageInterface;

final class Message implements AsyncMessageInterface
{
    private string $content;
    private int $smallNumber;
    private int $bigNumber;

    public function __construct(string $content, int $smallNumber, int $bigNumber)
    {
        $this->content = $content;
        $this->smallNumber = $smallNumber;
        $this->bigNumber = $bigNumber;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getSmallNumber(): int
    {
        return $this->smallNumber;
    }

    public function getBigNumber(): int
    {
        return $this->bigNumber;
    }
}
