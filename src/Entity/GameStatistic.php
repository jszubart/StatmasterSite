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
     * @ORM\ManyToOne(targetEntity="App\Entity\Game", inversedBy="statistics", cascade={"persist"}))
     * @ORM\JoinColumn(nullable=false)
     */
    private $game;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\GameEvent", inversedBy="gameStatistic", cascade={"persist"} )
     * @ORM\JoinColumn(nullable=false)
     */
    private $gameEvent;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Player", inversedBy="statistic", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $player;

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

    /**
     * @return mixed
     */
    public function getPlayer()
    {
        return $this->player;
    }

    /**
     * @param mixed $player
     */
    public function setPlayer($player): void
    {
        $this->player = $player;
    }
}
