<?php

namespace App\Command;

use App\Entity\Reaction;
use App\Entity\Talk;
use App\Repository\TalkRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Attribute\Option;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Yaml\Yaml;

#[AsCommand('app:load-data', 'Load the talk schedule and users')]
final class AppLoadDataCommand
{

    public function __construct(
        private TalkRepository $talkRepository,
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private SluggerInterface $asciiSlugger,
        private array $existingTalks = []
    )
    {
    }

    public function __invoke(
        SymfonyStyle $io,

        #[Option(description: 'reset the database first')] bool $reset = false,
        #[Option(description: 'limit the number of talks')] int $limit = 0,
    ): int {

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
                    if ($count == 1) {
                        $reaction = (new Reaction())
                            ->setType('message')
                            ->setMessage("Awesome!")
                            ->setCreatedAt(new \DateTimeImmutable())
                            ;
                        $x = $reaction->getCreatedAt();
                        $id = $reaction->getId();
                        $talk->addReaction($reaction);
                        $talk->addReaction($reaction); // duplicate, but we don't check
                        $talk->removeReaction($reaction);

                    }

                    if ($limit && ($count >= $limit)) {
                        break 2;
                    }
                }
            }
        }
        $this->entityManager->flush();
        $io->success('Talks now in database: ' . $this->talkRepository->count());

        // reactions?  really we need fixtures for tests.
        return Command::SUCCESS;
    }

    private function loadExisting(): void
    {
        foreach ($this->talkRepository->findAll() as $talk) {
            $this->existingTalks[$talk->getCode()] = $talk;
        }


    }
}
