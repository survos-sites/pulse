<?php

// uses Survos Param Converter, from the UniqueIdentifiers method of the entity.

namespace App\Controller;

use ApiPlatform\Api\IriConverterInterface;
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
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Workflow\WorkflowInterface;

#[Route('/talk/{talkId}')]
class TalkController extends AbstractController
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    // there must be a way to do this within the bundle, a separate route!
    #[Route(path: '/transition/{transition}', name: 'talk_transition')]
    public function transition(Request $request, WorkflowInterface $talkStateMachine, string $transition, Talk $talk): Response
    {
        if ('_' === $transition) {
            $transition = $request->request->get('transition'); // the _ is a hack to display the form, @todo: cleanup
        }

        $this->handleTransitionButtons($talkStateMachine, $transition, $talk);
        $this->entityManager->flush(); // to save the marking

        return $this->redirectToRoute('talk_show', $talk->getRP());
    }

    #[Route('/', name: 'talk_show', options: ['expose' => true])]
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

    #[Route('/_reactions', name: '_talk_reactions', options: ['expose' => true])]
    #[Template('talk/_reactions.html.twig')]
    public function reactions(Talk $talk): Response
    {
        return $this->render('talk/_reactions.html.twig', [
            'reactions' => $talk->getReactions()
        ]);
        return ['reactions' => $talk->getReactions()];


    }

    #[Route('/edit', name: 'talk_edit', options: ['expose' => true])]
    public function edit(Request $request, Talk $talk): Response
    {
        $form = $this->createForm(TalkType::class, $talk);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            return $this->redirectToRoute('talk_index');
        }

        return $this->render('talk/edit.html.twig', [
            'talk' => $talk,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete', name: 'talk_delete', methods: ['DELETE'])]
    public function delete(Request $request, Talk $talk): Response
    {
        // hard-coded to getId, should be get parameter of uniqueIdentifiers()
        if ($this->isCsrfTokenValid('delete'.$talk->getId(), $request->request->get('_token'))) {
            $entityManager = $this->entityManager;
            $entityManager->remove($talk);
            $entityManager->flush();
        }

        return $this->redirectToRoute('talk_index');
    }
}
