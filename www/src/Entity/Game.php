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
     * @ORM\OneToMany(targetEntity="App\Entity\GameStatistic", mappedBy="game")
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

    public function addStatistic(GameStatistic $statistic): self
    {
        if (!$this->statistics->contains($statistic)) {
            $this->statistics[] = $statistic;
            $statistic->setGame($this);
        }

        return $this;
    }

    public function removeStatistic(GameStatistic $statistic): self
    {
        if ($this->statistics->contains($statistic)) {
            $this->statistics->removeElement($statistic);
            // set the owning side to null (unless already changed)
            if ($statistic->getGame() === $this) {
                $statistic->setGame(null);
            }
        }

        return $this;
    }

    public function getSummaryScore(){

        $scores = $this->statistics;
        $summary = 0;
        foreach ($scores as $score){
            $summary+= $score->getScore();
        }
        return $summary;
    }
}
