<?php

namespace App\Repository;

use App\Entity\GameEvent;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameEvent|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameEvent|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameEvent[]    findAll()
 * @method GameEvent[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameEventRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameEvent::class);
    }
}
