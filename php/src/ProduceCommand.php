<?php

declare(strict_types=1);

namespace App;

use App\Message\Message;
use DateTimeImmutable;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Messenger\MessageBusInterface;

final class ProduceCommand extends Command
{
    public const COMMAND_NAME = 'app:messaging:produce';
    private const COMMAND_DESCRIPTION = 'Sends a message every few seconds.';
    private const SLEEP = 2;
    public const INT_32_LIMIT = 2147483647;
    public const INT_64_LIMIT = 9223372036854775807;
    private const MESSSAGES_LIMIT = 1;

    protected ConsoleHelper $consoleHelper;

    private MessageBusInterface $bus;

    public function __construct(
        MessageBusInterface $bus
    ) {
        parent::__construct();
        $this->bus = $bus;
        $this->consoleHelper = new ConsoleHelper();
    }

    protected function configure(): void
    {
        $this->setName(self::COMMAND_NAME)->setDescription(self::COMMAND_DESCRIPTION);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->consoleHelper->sayInfo($output, 'starting to dispatch...');
        $i = 0;
        while($i < self::MESSSAGES_LIMIT) {
            $msg = "Look! I created a message!\n"
                . "Source: PHP-producer\n"
                . "Time: " . (new DateTimeImmutable())->format('Y-m-d H:i:s');

            echo $msg . "\n" . self::INT_32_LIMIT . "\n" . self::INT_64_LIMIT . "\n";
            $this->bus->dispatch(
                new Message($msg, self::INT_32_LIMIT, self::INT_64_LIMIT)
            );

            $i++;
            sleep(self::SLEEP);
        }

        return 0;
    }
}
