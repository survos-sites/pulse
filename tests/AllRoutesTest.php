<?php

namespace App\Tests;

use App\Entity\User;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
use PHPUnit\Framework\Attributes\TestWith;
use Pierstoval\SmokeTesting\SmokeTestStaticRoutes;
use Survos\CrawlerBundle\Tests\VisitLinksTest;

class AllRoutesTest extends VisitLinksTest
{
    // That's all!

//    #[DataProvider('linksToVisit')]
//    #[TestWith(['tacman@gmail.com',User::class,'/api', 200])]
//    #[TestWith(['tacman@gmail.com',User::class,'/admin/commands', 200])]
    #[DataProvider('urlTests')] # must be static
    #[TestDox('$username $url should return $expected')]
    public function testWithLogin(?string $username, ?string $userClassName, string $url, int $expected): void
    {
        static $users = [];

        $browser = $this->browser();
//        $client = static::createClient();

        if ($username && $username != "") {
            if (!array_key_exists($username, $users)) {
                $container = static::getContainer();
                $users[$username] = $container->get('doctrine')->getRepository($userClassName)->findOneBy(['email' => $username]);
            }

            $user = $users[$username];
            assert($user, "Invalid user $username, not in user database");
            $browser->actingAs($user);
//            $client->loginUser($user);
        }
        $browser->visit($url);
//        $content = $browser->content(); // string - raw response body
        $browser->assertStatus($expected);

    }

    static public function urlTests()
    {
//        $text = [
//            ['admin','/', 200],
//            ['user', '/', 200],
//            ['admin', '/admin', 200],
//            ['user', '/admin', 403],
//            [null, '/admin', 302]
//        ];

        $x = [];
        $crawldataFilename = __DIR__ . '/crawldata.json';
        assert(file_exists($crawldataFilename));
        $crawldata = json_decode(file_get_contents($crawldataFilename));

        foreach ($crawldata as $username => $linksToCrawl) {
            $array = explode("|",$username);
            foreach ($linksToCrawl as $path=>$info) {
                // yield?
                $x[$username . '@' . $info->path] = [$array[0],$array[1], $info->path, 200];
            }
        }
        return $x;
    }

}
