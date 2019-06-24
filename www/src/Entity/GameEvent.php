<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\GameEventRepository")
 */
class GameEvent
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
     * @ORM\Column(type="string", length=255)
     */
    private $type;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\GameStatistic", mappedBy="gameEvent")
     */
    private $gameStatistic;

    public function __construct()
    {
        $this->gameStatistic = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getGameStatistic()
    {
        return $this->gameStatistic;
    }

    /**
     * @param mixed $gameStatistic
     */
    public function setGameStatistic($gameStatistic): void
    {
        $this->gameStatistic = $gameStatistic;
    }

    public function getImage(string $type){
        $attack_img = 'assets/uploads/attack.png';
        $defence_img = 'assets/uploads/defence.png';
        if($type == 'Attack'){
            return $attack_img;
        } else
            return $defence_img;
    }

    public function getPlayers(){
        $gameStatistics = $this->gameStatistic;
        $players = array();
        $ids = array();
        foreach($gameStatistics as $statistic){
            $id = $statistic->getPlayer()->getId();
            if(!in_array($id,$ids)) {
                $ids[]= $id;
                $players[]=$statistic->getPlayer();
            }
        }
        return $players;
    }

    public function getGames()
    {
        $gameStatistics = $this->gameStatistic;
        $games = array();
        $ids = array();
        foreach ($gameStatistics as $statistic) {
            $id = $statistic->getGame()->getId();
            if (!in_array($id, $ids)) {
                $ids[] = $id;
                $games[] = $statistic->getGame();
            }
        }
        return $games;
    }

}
