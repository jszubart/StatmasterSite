<?php

namespace App\Controller;

use App\Entity\GameStatistic;
use App\Form\GameStatisticType;
use App\Repository\GameRepository;
use App\Repository\GameStatisticRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/statistics")
 */
class GameStatisticController extends AbstractController
{

    private $gameRepository;
    private $gameStatisticRepository;

    public function __construct(GameRepository $gameRepository, GameStatisticRepository $gameStatisticRepository)
    {
        $this->gameRepository = $gameRepository;
        $this->gameStatisticRepository = $gameStatisticRepository;
    }

    /**
     * @Route("/", name="game_statistic_index", methods={"GET"})
     */
    public function index(GameStatisticRepository $gameStatisticRepository): Response
    {
        return $this->render('game_statistic/index.html.twig', [
            'game_statistics' => $gameStatisticRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="game_statistic_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $gameStatistic = new GameStatistic();
        $form = $this->createForm(GameStatisticType::class, $gameStatistic);
        $form->handleRequest($request);
        $game_id = $request->get('id');
        $game = $this->gameRepository->find($game_id);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameStatistic->setGame($game);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($gameStatistic);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'New event '. $gameStatistic->getGameEvent()->getName() . ' of '. $gameStatistic->getGameEvent()->getType().' has been added!'
            );

            return $this->redirectToRoute('game_show',['id' => $game_id]);
        }

        return $this->render('game_statistic/new.html.twig', [
            'game_statistic' => $gameStatistic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_statistic_show", methods={"GET"})
     */
    public function show(GameStatistic $gameStatistic): Response
    {
        return $this->render('game_statistic/show.html.twig', [
            'game_statistic' => $gameStatistic,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="game_statistic_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, GameStatistic $gameStatistic): Response
    {

        $this->denyAccessUnlessGranted('ROLE_USER');

        $form = $this->createForm(GameStatisticType::class, $gameStatistic);
        $player = $gameStatistic->getPlayer();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $gameStatistic->setPlayer($player);
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'info',
                'Event has been edited!'
            );

            return $this->redirectToRoute('game_statistic_show', [
                'id' => $gameStatistic->getId(),
            ]);
        }

        return $this->render('game_statistic/edit.html.twig', [
            'game_statistic' => $gameStatistic,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="game_statistic_delete", methods={"DELETE"})
     */
    public function delete(Request $request, GameStatistic $gameStatistic): Response
    {
        $this->denyAccessUnlessGranted('ROLE_USER');

        $game_id =$request->request->get('game');
        if ($this->isCsrfTokenValid('delete'.$gameStatistic->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gameStatistic);
            $entityManager->flush();

            $this->addFlash(
                'danger',
                'Event has been deleted!'
            );
        }

        return $this->redirectToRoute('game_show',['id' => $game_id]);
    }
}
