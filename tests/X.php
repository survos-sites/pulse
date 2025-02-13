<?php

namespace Tests;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Pierstoval\SmokeTesting\FunctionalSmokeTester;
use Pierstoval\SmokeTesting\FunctionalTestData;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class X extends WebTestCase
{
	use FunctionalSmokeTester;

	#[TestDox('/$method $url ($route)')]
	#[TestWith(['GET', 'https://pulse.wip/api', 'api_entrypoint'])]
	#[TestWith(['HEAD', 'https://pulse.wip/api', 'api_entrypoint'])]
	#[TestWith(['GET', 'https://pulse.wip/api/docs', 'api_doc'])]
	#[TestWith(['HEAD', 'https://pulse.wip/api/docs', 'api_doc'])]
	#[TestWith(['GET', 'https://pulse.wip/api/reactions', 'reactions_doctrine'])]
	#[TestWith(['GET', 'https://pulse.wip/api/talks', 'meili_talk'])]
	#[TestWith(['GET', 'https://pulse.wip/js/routing', 'fos_js_routing_js'])]
	#[TestWith(['GET', 'https://pulse.wip/auth/profile', 'oauth_profile'])]
	#[TestWith(['GET', 'https://pulse.wip/auth/providers', 'oauth_providers'])]
	#[TestWith(['GET', 'https://pulse.wip/admin/command/admin/commands/list', 'survos_commands'])]
	#[TestWith(['GET', 'https://pulse.wip/crawler/crawlerdata', 'survos_crawler_data'])]
	#[TestWith(['GET', 'https://pulse.wip/workflow/workflows', 'survos_workflows'])]
	#[TestWith(['GET', 'https://pulse.wip/logout', 'app_logout'])]
	#[TestWith(['GET', 'https://pulse.wip/', 'app_homepage'])]
	#[TestWith(['GET', 'https://pulse.wip/register', 'app_register'])]
	#[TestWith(['GET', 'https://pulse.wip/verify/email', 'app_verify_email'])]
	#[TestWith(['GET', 'https://pulse.wip/login', 'app_login'])]
	#[TestWith(['GET', 'https://pulse.wip/talks/browse/', 'talk_browse'])]
	#[TestWith(['GET', 'https://pulse.wip/talks/', 'talk_index'])]
	#[TestWith(['GET', 'https://pulse.wip/talks/symfony_crud_index', 'talk_symfony_crud_index'])]
	#[TestWith(['GET', 'https://pulse.wip/talkstalk/new', 'talk_new'])]
	public function testRoute(string $method, string $url, string $route): void
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
