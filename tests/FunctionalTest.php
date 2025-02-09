<?php

namespace App\Tests;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Pierstoval\SmokeTesting\FunctionalSmokeTester;
use Pierstoval\SmokeTesting\FunctionalTestData;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class FunctionalTest extends WebTestCase
{
    use FunctionalSmokeTester;

    #[TestWith(['/api', 'api_entrypoint', 'GET'])]
    #[TestWith(['/api', 'api_entrypoint', 'HEAD'])]
    #[TestWith(['/api/docs', 'api_doc', 'GET'])]
    #[TestWith(['/api/docs', 'api_doc', 'HEAD'])]
    #[TestWith(['/api/reactions', 'reactions_doctrine', 'GET'])]
    #[TestWith(['/api/talks', 'meili_talk', 'GET'])]
    #[TestWith(['/js/routing', 'fos_js_routing_js', 'GET'])]
    #[TestWith(['/auth/profile', 'oauth_profile', 'GET'])]
    #[TestWith(['/auth/providers', 'oauth_providers', 'GET'])]
    #[TestWith(['/crawler/crawlerdata', 'survos_crawler_data', 'GET'])]
    #[TestWith(['/workflow/workflows', 'survos_workflows', 'GET'])]
    #[TestWith(['/logout', 'app_logout', 'GET'])]
    #[TestWith(['/', 'app_homepage', 'GET'])]
    #[TestWith(['/register', 'app_register', 'GET'])]
    #[TestWith(['/verify/email', 'app_verify_email', 'GET'])]
    #[TestWith(['/login', 'app_login', 'GET'])]
    #[TestWith(['/talks/browse/', 'talk_browse', 'GET'])]
    #[TestWith(['/talks/', 'talk_index', 'GET'])]
    #[TestWith(['/talks/symfony_crud_index', 'talk_symfony_crud_index', 'GET'])]
    #[TestWith(['/talkstalk/new', 'talk_new', 'GET'])]
    #[TestDox('/$method $url ($route)')]
    public function testRoute(string $url, string $route, string $method = 'GET'): void
    {
        $this->runFunctionalTest(
            FunctionalTestData::withUrl($url)
                ->withMethod($method)
                ->expectRouteName($route)
                ->appendCallableExpectation($this->assertStatusCodeLessThan500($method, $url))
        );
    }

    public function assertStatusCodeLessThan500(string $method, string $url): \Closure
    {
        return function (KernelBrowser $browser) use ($method, $url) {
            $statusCode = $browser->getResponse()->getStatusCode();
            $routeName = $browser->getRequest()->attributes->get('_route', 'unknown');

            static::assertLessThan(
                500,
                $statusCode,
                sprintf('Request "%s %s" for %s route returned an internal error.', $method, $url, $routeName),
            );
        };
    }
}
