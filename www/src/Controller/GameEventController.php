<?php

namespace App\Controller;

use App\Entity\GameEvent;
use App\Form\GameEventType;
use App\Repository\GameEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game/event")
 */
class GameEventController extends AbstractController
{
    /**
     * @Route("/", name="game_event_index", methods={"GET"})
     */
    public function index(GameEventRepository $gameEventRepository): Response
    {
        return $this->render('game_event/index.html.twig', [
            'game_events' => $gameEventRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="game_event_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $gameEvent = new GameEvent();
        $form = $this->createForm(GameEventType::class, $gameEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gameEvent);
            $entityManager->flush();

            return $this->redirectToRoute('game_event_index');
        }

        return $this->render('game_event/new.html.twig', [
            'game_event' => $gameEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_event_show", methods={"GET"})
     */
    public function show(GameEvent $gameEvent): Response
    {
        return $this->render('game_event/show.html.twig', [
            'game_event' => $gameEvent,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_event_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GameEvent $gameEvent): Response
    {
        $form = $this->createForm(GameEventType::class, $gameEvent);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('game_event_index', [
                'id' => $gameEvent->getId(),
            ]);
        }

        return $this->render('game_event/edit.html.twig', [
            'game_event' => $gameEvent,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_event_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GameEvent $gameEvent): Response
    {
        if ($this->isCsrfTokenValid('delete'.$gameEvent->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameEvent);
            $entityManager->flush();
        }

        return $this->redirectToRoute('game_event_index');
    }
}
