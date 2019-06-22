<?php

namespace App\Controller;

use App\Entity\GameEvent;
use App\Repository\GameEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/game_events")
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

    /**
     * @Route("/{id}/ranking", name="game_event_ranking", methods={"GET"})
     */
    public function ranking(Request $request, GameEvent $gameEvent): Response
    {
        return $this->render('game_event/ranking.html.twig', [
            'game_event' => $gameEvent,
        ]);
    }
}
