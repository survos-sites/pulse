<?php

namespace App\Tests\Crawl;

use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Survos\CrawlerBundle\Tests\BaseVisitLinksTest;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CrawlAstacmanTest extends BaseVisitLinksTest
{
	#[TestDox('/$method $url ($route)')]
	#[TestWith(['tacman@gmail.com', 'App\Entity\User', '/', 200])]
	#[TestWith(['tacman@gmail.com', 'App\Entity\User', '/talks/browse/', 200])]
	#[TestWith(['tacman@gmail.com', 'App\Entity\User', '/talks/', 200])]
	#[TestWith(['tacman@gmail.com', 'App\Entity\User', '/talks/symfony_crud_index', 200])]
	#[TestWith(['tacman@gmail.com', 'App\Entity\User', '/auth/profile', 200])]
	#[TestWith(['tacman@gmail.com', 'App\Entity\User', '/talk/Opening-Welcome-session/', 200])]
	#[TestWith(['tacman@gmail.com', 'App\Entity\User', '/talk/Keynote/', 200])]
	#[TestWith(['tacman@gmail.com', 'App\Entity\User', '/talk/Symfony-Forms-Advanced-Use-Cases/', 200])]
	public function testRoute(string $username, string $userClassName, string $url, string|int|null $expected): void
	{
		parent::testWithLogin($username, $userClassName, $url, (int)$expected);
	}
}
