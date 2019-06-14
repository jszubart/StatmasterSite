<?php

namespace App\Controller\Rest;

use App\Entity\Game;
use App\Entity\GameEvent;
use App\Entity\GameStatistic;
use App\Form\GameStatisticType;
use App\Form\GameType;
use Doctrine\ORM\EntityManagerInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Routing\ClassResourceInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class RestController extends AbstractFOSRestController implements ClassResourceInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Rest\Post("/game/new")
     */
    public function postGame(Request $request)
    {
        $data = json_decode($request->getContent(), true);

        $game_info = array();
        $statistics = array();
        $teamName = $data[0]['teamName'];
        $gameDate = date_create_from_format('d-M-Y H:i', $data[0]['gameDate']);
        $gameCoach = $data[0]['teamCoach'];
        $repository = $this->entityManager->getRepository(Game::class);
        $repository_event = $this->entityManager->getRepository(GameEvent::class);

        if ($repository->findOneBy(['gameDate' => $gameDate, 'teamName' => $teamName ]) == null){
            $game = new Game ;
            $form_game = $this->createForm(GameType::class, $game);
            $form_game->submit($data);
            if ($form_game->isSubmitted() && $form_game->isValid()) {
                $game->setTeamName($teamName);
                $game->setGameDate($gameDate);
                $game->setGameCoach($gameCoach);
                $game_info = [$teamName, $gameDate, $gameCoach];
                $this->entityManager->persist($game);
            }

            foreach ($data as $object) {
                $gameStatistics = new GameStatistic();
                $gameStatistics->setPlayerName($object['playerName']);
                $event = $repository_event->findOneBy(['name' => $object['eventName']]);
                $gameStatistics->setGameEvent($event);
                $gameStatistics->setGame($game);
                $statistics [] = [$object['playerName'], $event->getName(), $event->getScore()];
                $this->entityManager->persist($gameStatistics);
            }
            $this->entityManager->flush();
            return $this->handleView($this->view([$game_info,$statistics],Response::HTTP_OK));
        } else
            return $this->handleView($this->view(null,Response::HTTP_NO_CONTENT));
    }
}