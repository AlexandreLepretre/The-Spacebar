<?php

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\QueryBuilder;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[] findAll()
 * @method Article[] findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * Class ArticleRepository
 * @package App\Repository
 */
class ArticleRepository extends ServiceEntityRepository
{
    /**
     * ArticleRepository constructor.
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    /**
     * @return Article[]
     */
    public function findAllPublishedOrderedByNewest()
    {
        return $this->addIsPublishedQueryBuilder()->orderBy('a.publishedAt', 'DESC')->getQuery()->getResult();
    }

    /**
     * @param QueryBuilder|null $queryBuilder
     * @return QueryBuilder
     */
    private function addIsPublishedQueryBuilder(QueryBuilder $queryBuilder = null)
    {
        return $this->getOrCreateQueryBuilder($queryBuilder)->andWhere('a.publishedAt IS NOT NULL');
    }

    /**
     * @return Criteria
     */
    public static function createNonDeletedCriteria(): Criteria
    {
        return Criteria::create()->andWhere(Criteria::expr()->eq('isDeleted', false))
            ->orderBy(['createdAt' => 'DESC']);
    }

    /**
     * @param QueryBuilder|null $queryBuilder
     * @return QueryBuilder
     */
    private function getOrCreateQueryBuilder(QueryBuilder $queryBuilder = null)
    {
        return $queryBuilder ?: $this->createQueryBuilder('a');
    }
}
