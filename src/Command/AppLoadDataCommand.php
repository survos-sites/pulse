<?php

namespace App\Command;

use App\Entity\Talk;
use App\Repository\TalkRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Yaml\Yaml;
use Zenstruck\Console\Attribute\Option;
use Zenstruck\Console\ConfigureWithAttributes;
use Zenstruck\Console\InvokableServiceCommand;
use Zenstruck\Console\IO;
use Zenstruck\Console\RunsCommands;
use Zenstruck\Console\RunsProcesses;

#[AsCommand('app:load-data', 'Load the talk schedule and users')]
final class AppLoadDataCommand extends InvokableServiceCommand
{
    use RunsCommands;
    use RunsProcesses;

    public function __construct(
        private TalkRepository $talkRepository,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private SluggerInterface $asciiSlugger,
        private array $existingTalks = []
    )
    {
        parent::__construct();
    }

    public function __invoke(
        IO $io,

        #[Option(description: 'reset the database first')] bool $reset = false,
        #[Option(description: 'limit the number of talks')] int $limit = 0,
    ): void {

        if ($reset) {
            foreach ($this->talkRepository->findAll() as $talk) {
                $this->entityManager->remove($talk);
            }
            $this->entityManager->flush();
        }
        $this->loadExisting();
        $user = $this->userRepository->findOneBy(['email' => 'tacman@gmail.com']);
        assert($user, "run bin/create-admins.sh");
        $fn = __DIR__ . '/../../assets/data/schedule.yaml';
        $events = Yaml::parseFile($fn)['events'];
        $count = 0;
        foreach ($events as $idx=>$event) {
            foreach ($event['schedules'] as $schedule) {
                foreach ($schedule['talks'] as $talkData) {
                    $count++;
                    $code = $this->asciiSlugger->slug($talkData['name'])->toString();
                    if (!$talk = $this->existingTalks[$code]??null) {
                        $talk = (new Talk())
                            ->setId($count)
                            ->setCode($code)
                            ->setUser($user);
                        $this->entityManager->persist($talk);
                        $this->existingTalks[$code] = $talk;
                    }
                    $talk->setData($talkData);
                    // @todo: update the talk with speakers, time, etc.
                    $talk->setTitle($talkData['name']);

                    if ($limit && ($count >= $limit)) {
                        break 2;
                    }
                }
            }
        }
        $this->entityManager->flush();
        $io->success('Talks now in database: ' . $this->talkRepository->count());

        // reactions?  really we need fixtures for tests.
    }

    private function loadExisting(): void
    {
        foreach ($this->talkRepository->findAll() as $talk) {
            $this->existingTalks[$talk->getCode()] = $talk;
        }


    }
}
