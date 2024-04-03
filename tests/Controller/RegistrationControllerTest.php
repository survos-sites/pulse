<?php

namespace App\Tests\Controller;

// https://behat.org/en/latest/user_guide/writing_scenarios.html

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Zenstruck\Browser\Test\HasBrowser;

class RegistrationControllerTest extends WebTestCase
{
    use HasBrowser;
    public function testSomething(): void
    {
        /** @var UserRepository $userRepo */
        $userRepo = $this->getContainer()->get(UserRepository::class);
        $em = $this->getContainer()->get(EntityManagerInterface::class);
        $email = 'tacmanx@gmail.com';
        if ($user = $userRepo->findOneBy(['email' => $email])) {
            $em->remove($user);
            $em->flush();
        }


        $browser = $this->browser();

        $browser->get('/register')
            ->assertContains('Register');

        $browser
            ->fillField('Email', $email)
            ->fillField('registration_form_plainPassword', 'abcdefghi')
            ->checkField('registration_form_agreeTerms')
            ->click('reg_submit_btn');
        $browser->assertStatus(200);
        if ($user = $userRepo->findOneBy(['email' => $email])) {
            $browser->get('/verify/email?id=' . $user->getId());
        }

//        $client = static::createClient();
//        $crawler = $client->request('GET', '/');
//
//        $this->assertResponseIsSuccessful();
//        $this->assertSelectorTextContains('h1', 'Hello World');
    }
}
