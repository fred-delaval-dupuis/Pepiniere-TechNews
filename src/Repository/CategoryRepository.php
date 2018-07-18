<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Category::class);
    }

    public function getCategoryAndArticles(Category $category)
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->innerJoin('c.articles', 'a')
            ->addSelect('a')
            ->where('c.id = :id')
            ->setParameter('id', $category->getId())
        ;

        try {
            return $qb->getQuery()->getSingleResult();
        } catch (\Exception $e) {
            return $category;
        }
    }

    public function findCategoriesHavingArticles()
    {
        $qb = $this
            ->createQueryBuilder('c')
            ->innerJoin('c.articles', 'a')
        ;

        return $qb->getQuery()->getResult();
    }
}
