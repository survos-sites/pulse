<?php

namespace App\Tests;

use App\Repository\ReactionRepository;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReactionTest extends KernelTestCase
{
    public function testSomething(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        // $routerService = static::getContainer()->get('router');
        // $myCustomService = static::getContainer()->get(CustomService::class);
        $reactionRepo = static::getContainer()->get(ReactionRepository::class);
        $count = $reactionRepo->count([]);
        $this->assertTrue(is_integer($count));
    }
}
