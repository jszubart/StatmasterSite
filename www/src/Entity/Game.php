<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameRepository")
 */
class Game
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $gameDate;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $teamName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $gameCoach;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameStatistic", mappedBy="game", cascade={"persist", "remove"})
     */
    private $statistics;


    public function __construct()
    {
        $this->statistics = new ArrayCollection();

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
    public function getGameDate()
    {
        return $this->gameDate;
    }

    /**
     * @param mixed $gameDate
     */
    public function setGameDate($gameDate): void
    {
        $this->gameDate = $gameDate;
    }

    /**
     * @return mixed
     */
    public function getTeamName()
    {
        return $this->teamName;
    }

    /**
     * @param mixed $teamName
     */
    public function setTeamName($teamName): void
    {
        $this->teamName = $teamName;
    }

    /**
     * @return mixed
     */
    public function getGameCoach()
    {
        return $this->gameCoach;
    }

    /**
     * @param mixed $gameCoach
     */
    public function setGameCoach($gameCoach): void
    {
        $this->gameCoach = $gameCoach;
    }

    /**
     * @return Collection|GameStatistic[]
     */
    public function getStatistics(): Collection
    {
        return $this->statistics;
    }

    public function getSummaryScore()
    {
        $scores = $this->statistics;
        $summary = 0;
        foreach ($scores as $score) {
            $summary += $score->getGameEvent()->getScore();
        }
        return $summary;
    }
    public function getEventCount(string $event_name)
    {
        $statistics = $this->statistics;
        $counter = 0;
        foreach ($statistics as $statistic) {
            if ($statistic->getGameEvent()->getName() == $event_name) {
                $counter += 1;
            }
        }
        return $counter;
    }
}
