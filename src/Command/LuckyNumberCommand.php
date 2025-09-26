<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\Argument;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

#[AsCommand(name: 'lucky:number')]
class LuckyNumberCommand extends Command
{
    public function __construct()
    {
        parent::__construct();
    }

    public function __invoke(
        InputInterface $input,
        OutputInterface $output,
        SymfonyStyle       $io,
        #[Argument] ?string $name=null,
        #[Option] ?bool     $formal = null,
        #[Option] ?string $color=null,
    ): void
    {
//        $formal ??= false;
        $helper = $this->getHelper('question');

        if (!$name) {
            $question = new Question('What name would you like to be called?');
            $name = $io->askQuestion($question);
        }

        if (!$color) {
            $question = new ChoiceQuestion(
                'Please select your favorite color (defaults to red)',
                // choices can also be PHP objects that implement __toString() method
                ['red', 'blue', 'yellow'],
                0
            );
            $question->setErrorMessage('Color %s is invalid.');
            $color = $io->askQuestion($question);
            $x = $io->ask('thoughts?');
            $output->writeln('You have just answered: '.$x);

        }
        $output->writeln('Selected Color: '.$color);

        $io->title(sprintf('%s %s!', $formal ? 'Hello' : 'Hey', ucfirst($name)));
        $io->success(sprintf('Today\'s Lucky Number: %d', rand(0, 400)));
    }
}
