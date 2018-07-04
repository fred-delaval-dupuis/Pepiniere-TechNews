<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 14:10
 */

namespace App\Provider;


use App\Article\ArticlesRepositoryInterface;
use App\Article\Factory\AbstractFactoryInterface;
use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProvider extends AbstractProvider
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @inheritDoc
     */
    public function __construct(ArticlesRepositoryInterface $repository = null, AbstractFactoryInterface $factory = null, EntityManagerInterface $entityManager)
    {
        parent::__construct($repository, $factory);
        $this->em = $entityManager;
    }

    public function find(int $id): Article
    {
        return $this->em->getRepository(Article::class)->find($id);
    }

    public function findOneBy(array $criteria): Article
    {
        return $this->em->getRepository(Article::class)->findOneBy($criteria);
    }

    public function findAll(): array
    {
        return $this->em->getRepository(Article::class)->findAll();
    }

    public function findLastFiveArticles(): array
    {
        return $this->em->getRepository(Article::class)->findLastFiveArticles();
    }

    public function findSpecialArticles(): array
    {
        return $this->em->getRepository(Article::class)->findSpecialArticles();
    }

    public function findSpotlightArticles(): array
    {
        return $this->em->getRepository(Article::class)->findSpotlightArticles();
    }

}