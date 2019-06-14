<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameStatisticRepository")
 */
class GameStatistic
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $playerName;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="statistics", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameEvent", inversedBy="gameStatistic", cascade={"persist"} )
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameEvent;

    public function __construct()
    {
        $this->gameEvent = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getPlayerName()
    {
        return $this->playerName;
    }

    /**
     * @param mixed $playerName
     */
    public function setPlayerName($playerName): void
    {
        $this->playerName = $playerName;
    }

    /**
     * @return mixed
     */
    public function getGame()
    {
        return $this->game;
    }

    /**
     * @param mixed $game
     */
    public function setGame($game): void
    {
        $this->game = $game;
    }

    /**
     * @return mixed
     */
    public function getGameEvent()
    {
        return $this->gameEvent;
    }

    /**
     * @param mixed $gameEvent
     */
    public function setGameEvent($gameEvent): void
    {
        $this->gameEvent = $gameEvent;
    }
}
