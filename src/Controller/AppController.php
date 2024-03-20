<?php

namespace App\Controller;

use App\Repository\PlanetRepository;
use App\Repository\TalkRepository;
use Survos\PwaExtraBundle\Attribute\PwaExtra;
use Survos\PwaExtraBundle\Service\PwaService;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class AppController extends AbstractController
{
    #[Route('/', name: 'app_homepage')]
    public function index(TalkRepository $talkRepository): Response
    {
        return $this->render('app/index.html.twig', [
            'controller_name' => 'AppController',
            'talks' => $talkRepository->findAll()
        ]);
    }


    #[Route('/onsen', name: 'app_onsen')]
    #[Template('app/onsen.html.twig')]
    #[PwaExtra(cacheStrategy: PwaService::CacheFirst)]
    public function onsen(TalkRepository $planetRepository): array
    {
        return ['planets' => $planetRepository->findAll()];
    }

}
