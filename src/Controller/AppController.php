<?php

namespace App\Controller;

use App\Repository\TalkRepository;
use DOMDocument;
use DOMXPath;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Cache\CacheItem;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\Cache\CacheInterface;


class AppController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(TalkRepository $talkRepository): Response
    {
//        return new Response($this->getUser() ? $this->getUser()->getUserIdentifier() : 'not logged in');
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'talks' => $talkRepository->findAll()
        ]);
    }

    #[Route('/scrape', name: 'app_scrape')]
    public function scrape(CacheInterface $cache): Response
    {
// Fetch the page content
        $html = $cache->get('html', function (CacheItem $item) {
            $client = HttpClient::create();
            $response = $client->request('GET', 'https://live.symfony.com/2025-online-june/schedule');
            $html = $response->getContent();
            return $html;
        });

// Load into DomCrawler
        $crawler = new Crawler($html);

// Filter the talk block by unique ID or use a loop for all talks
        $crawler->filter('.pt-12')->each(function (Crawler $node) {
            // Title
            $title = $node->filter('h3 a')->text();

            $description = $node->filter('.mb-4')->text();
//            dd($node->html());
            $speaker = $node->filter('.link')->text();

            dd($title, $description, $speaker, $node->html());
            $link = 'https://live.symfony.com' . $node->filter('h3 a')->attr('href');

            // Speaker name and profile URL
            $speaker = $node->filter('a.link span')->text();
            $speakerProfile = $node->filter('a.link')->attr('href');

            // Description
            $description = $node->filter('.editable-content')->text();

            // Language
            $language = $node->filterXPath('//div[contains(@class, "flex") and contains(., "Delivered in")]')->text();

            // Output
            echo "Title: $title\n";
            echo "Link: $link\n";
            echo "Speaker: $speaker\n";
            echo "Speaker Profile: $speakerProfile\n";
            echo "Language: $language\n";
            echo "Description: \n$description\n";
            echo str_repeat('-', 40) . "\n";
        });

    }


}
