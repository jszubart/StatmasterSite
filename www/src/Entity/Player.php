<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PlayerRepository")
 */
class Player
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameStatistic", mappedBy="player", cascade={"persist", "remove"})
     */
    private $statistic;

    public function __construct()
    {
        $this->statistic = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection|GameStatistic[]
     */
    public function getStatistic(): Collection
    {
        return $this->statistic;
    }

    public function addStatistic(GameStatistic $statistic): self
    {
        if (!$this->statistic->contains($statistic)) {
            $this->statistic[] = $statistic;
            $statistic->setPlayer($this);
        }

        return $this;
    }

    public function removeStatistic(GameStatistic $statistic): self
    {
        if ($this->statistic->contains($statistic)) {
            $this->statistic->removeElement($statistic);
            // set the owning side to null (unless already changed)
            if ($statistic->getPlayer() === $this) {
                $statistic->setPlayer(null);
            }
        }

        return $this;
    }

    public function getGames(){
        $statistics = $this->statistic;
        $ids = array();
        $games = array();
        foreach ($statistics as $statistic){
           $id = $statistic->getGame()->getId();
            if(!in_array($id,$ids)){
                $ids[]= $id;
                $games[] = $statistic->getGame();
            }
        }
        return $games;
    }

    public function getSummaryScore(string $type)
    {
        $statistics = $this->statistic;
        $score = 0;
        foreach ($statistics as $statistic) {
            if($statistic->getGameEvent()->getType() == $type) {
                $score += $statistic->getGameEvent()->getScore();
            }
            if($type == 'Summary'){
                $score += $statistic->getGameEvent()->getScore();
            }
        }
        return $score;
    }

    public function getSpecificStatistics(string $type){
        $statistics = $this->statistic;
        $statistics_of_type = array();
        foreach ($statistics as $statistic){
            if($statistic->getGameEvent()->getType() == $type){
                $statistics_of_type [] = $statistic;
            }
        }
        return $statistics_of_type;
    }

}
