<?php

namespace App\Repository;

use App\Entity\Article;
use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\Tools\Pagination\Paginator;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function findLastFiveArticles()
    {
        return $this
            ->createQueryBuilder('a')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(5)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findArticlesSuggestions($article_id, $category_id)
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.category = :category_id')
            ->setParameter('category_id', $category_id)
            ->andWhere('a.id != :article_id')
            ->setParameter('article_id', $article_id)
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSpotlightArticles()
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.spotlight = 1')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }

    public function findSpecialArticles()
    {
        return $this
            ->createQueryBuilder('a')
            ->where('a.special = 1')
            ->orderBy('a.createdAt', 'DESC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
            ;
    }

    public function findPaginatedArticles(Category $category, int $page, int $nbPerPage)
    {

        $qb = $this
            ->createQueryBuilder('a')
            ->where('a.category = :category')
            ->setParameter('category', $category)
            ->setFirstResult(($page - 1) * $nbPerPage)
            ->setMaxResults($nbPerPage)
        ;

        $pagination = new Paginator($qb);
        return $pagination;
    }
}
