<?php

// uses Survos Param Converter, from the UniqueIdentifiers method of the entity.

namespace App\Controller;

use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\IriConverterInterface;
use App\Entity\Talk;
use App\Form\TalkType;
use App\Repository\TalkRepository;
use Doctrine\ORM\EntityManagerInterface;
use Survos\ApiGrid\Components\ApiGridComponent;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
// @todo: if Workflow Bundle active
use Symfony\Component\Routing\Attribute\Route;

#[Route('/talks')]
class TalkCollectionController extends AbstractController
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private ApiGridComponent $apiGridComponent,
        private ?IriConverterInterface $iriConverter = null
    ) {
    }

    #[Route(path: '/browse/', name: 'talk_browse', methods: ['GET'])]
    #[Route('/', name: 'talk_index')]
    public function browsetalk(Request $request): Response
    {
        $class = Talk::class;
        $shortClass = 'Talk';
//        $useMeili = 'app_browse' == $request->get('_route');
        // this should be from inspection bundle!
//        $apiCall = $useMeili
//        ? '/api/meili/'.$shortClass
//        : $this->iriConverter->getIriFromResource($class, operation: new GetCollection(),
//            context: $context ?? [])
//        ;

        $this->apiGridComponent->setClass($class);
        $c = $this->apiGridComponent->getDefaultColumns();
        $columns = array_values($c);
        $useMeili = 'talk_browse' == $request->get('_route');
        // this should be from inspection bundle!
        $apiCall = $useMeili
            ? '/api/meili/' . $shortClass
            : $this->iriConverter->getIriFromResource($class, operation: new GetCollection(), context: []);
//            context: $context ?? [])

        return $this->render('talk/browse.html.twig', [
            'class' => $class,
            'useMeili' => $useMeili,
            'apiCall' => $apiCall,
            'columns' => $columns,
            'filter' => [],
        ]);
    }

    #[Route('/symfony_crud_index', name: 'talk_symfony_crud_index')]
    public function symfony_crud_index(TalkRepository $talkRepository): Response
    {
        return $this->render('talk/index.html.twig', [
            'talks' => $talkRepository->findBy([], [], 30),
        ]);
    }

}
