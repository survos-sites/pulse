<?php

// uses Survos Param Converter, from the UniqueIdentifiers method of the entity.

namespace App\Controller;

use ApiPlatform\Metadata\IriConverterInterface;
use App\Entity\Reaction;
use App\Entity\Talk;
use App\Form\ReactionFormType;
use App\Form\TalkType;
use Doctrine\ORM\EntityManagerInterface;
use Survos\InspectionBundle\Services\InspectionService;
use Symfony\Bridge\Twig\Attribute\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('/talk/{talkId}', name: 'talk_')]
class TalkController extends AbstractController
{
    public const SHOW = 'show';
    public const EDIT = 'edit';
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    #[Route('/', name: self::SHOW, options: ['expose' => true])]
    public function show(Request $request,
                         IriConverterInterface $iriConverter,
                         Talk $talk): Response
    {
        $url = $iriConverter->getIriFromResource($talk);
        $reaction = (new Reaction())->setTalk($talk);
        $reaction->setType("message")
            ->setMessage("awesome! " . rand(100, 10000));
        $form = $this->createForm(ReactionFormType::class, $reaction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->entityManager;
            $entityManager->persist($reaction);
            $entityManager->flush();

            return $this->redirectToRoute('talk_show', $talk->getrp());
        }
        return $this->render('talk/show.html.twig', [
            'apiUrl' => $url,
            'talk' => $talk,
            'form' => $form->createView()
        ]);
    }

    #[Route('/_reactions', name: '_reactions', options: ['expose' => true])]
    #[Template('talk/_reactions.html.twig')]
//    #[Template(new Expression(
//        '"ROLE_ADMIN" in role_names or (is_authenticated() and user.isSuperAdmin()) or (request.query.get("admin_view")' ? 'admin/talk.html.twig' : 'visitor/talk.html.twig',
//    ))]
    public function reactions(Talk $talk,
        #[MapQueryParameter()] bool $embedded = false,
    ): Response|array
    {
        return $embedded
            ? $this->render('talk/_reactions.html.twig', [
                'reactions' => $talk->getReactions()
            ])
            : ['reactions' => $talk->getReactions()];


    }


}
