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

        #[Option(description: 'reset the database first')]
        bool $reset = false,
    ): void {

        $this->loadExisting();
        $user = $this->userRepository->findOneBy(['email' => 'tacman@gmail.com']);
        assert($user, "run bin/load-admins.sh");
        $fn = __DIR__ . '/../../assets/data/schedule.yaml';
        $events = Yaml::parseFile($fn)['events'];
        foreach ($events as $event) {
            foreach ($event['schedules'] as $schedule) {
                foreach ($schedule['talks'] as $talkData) {
                    $code = $this->asciiSlugger->slug($talkData['name'])->toString();
                    if (!$talk = $this->existingTalks[$code]??null) {
                        $talk = (new Talk())
                            ->setCode($code)
                            ->setUser($user);
                        $this->entityManager->persist($talk);
                        $this->existingTalks[$code] = $talk;
                    }
                    $talk->setData($talkData);
                    // @todo: update the talk with speakers, time, etc.
                    $talk->setTitle($talkData['name']);
                }
            }
        }
        $this->entityManager->flush();
        $io->success('Talks now in database: ' . $this->talkRepository->count());
    }

    private function loadExisting()
    {
        foreach ($this->talkRepository->findAll() as $talk) {
            $this->existingTalks[$talk->getCode()] = $talk;
        }


    }
}
