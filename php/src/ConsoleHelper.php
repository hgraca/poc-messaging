<?php

declare(strict_types=1);

namespace App;

use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use const PHP_EOL;

final class ConsoleHelper
{
    /** @var QuestionHelper */
    private $questionHelper;

    public const QUESTION = '<question>%s</question>';
    public const TEXT = '%s';
    public const COMMENT = '<comment>%s</comment>';
    public const INFO = '<info>%s</info>';
    public const ERROR = PHP_EOL . '<error>%s</error>' . PHP_EOL;
    public const EXIT_CODE_SUCCESS = 0;
    public const EXIT_CODE_FAILURE = 1;

    public function __construct(QuestionHelper $questionHelper = null)
    {
        $this->questionHelper = $questionHelper ?? new QuestionHelper();
    }

    public function ask(
        InputInterface $input,
        OutputInterface $output,
        string $question,
        string $defaultValue = null
    ): string {
        return $this->questionHelper->ask(
            $input,
            $output,
            new Question($this->createQuestionMessage($question), $defaultValue)
        );
    }

    public function askConfirmation(
        InputInterface $input,
        OutputInterface $output,
        string $question,
        bool $defaultValue = false,
        string $trueAnswerRegex = '/^y/i'
    ): bool {
        return $this->questionHelper->ask(
            $input,
            $output,
            new ConfirmationQuestion($this->createQuestionMessage($question), $defaultValue, $trueAnswerRegex)
        );
    }

    public function say(OutputInterface $output, string $comment): void
    {
        $output->writeln($this->createMessage($comment));
    }

    public function sayComment(OutputInterface $output, string $comment): void
    {
        $output->writeln($this->createCommentMessage($comment));
    }

    public function sayInfo(OutputInterface $output, string $info): void
    {
        $output->writeln($this->createInfoMessage($info));
    }

    public function sayError(OutputInterface $output, string $error): void
    {
        $output->writeln($this->createErrorMessage($error));
    }

    private function createQuestionMessage(string $text): string
    {
        return sprintf(self::QUESTION, $text);
    }

    private function createMessage(string $text): string
    {
        return sprintf(self::TEXT, $text);
    }

    private function createCommentMessage(string $text): string
    {
        return sprintf(self::COMMENT, $text);
    }

    private function createInfoMessage(string $text): string
    {
        return sprintf(self::INFO, $text);
    }

    private function createErrorMessage(string $text): string
    {
        return sprintf(self::ERROR, $text);
    }
}
