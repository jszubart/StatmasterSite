<?php

namespace App\Repository;

use App\Entity\GameStatistic;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method GameStatistic|null find($id, $lockMode = null, $lockVersion = null)
 * @method GameStatistic|null findOneBy(array $criteria, array $orderBy = null)
 * @method GameStatistic[]    findAll()
 * @method GameStatistic[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GameStatisticRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, GameStatistic::class);
    }

}
