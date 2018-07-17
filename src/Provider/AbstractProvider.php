<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 12:23
 */

namespace App\Provider;

use App\Article\ArticlesRepositoryInterface;
use App\Article\Factory\AbstractFactoryInterface;

abstract class AbstractProvider implements ProviderInterface
{
    /**
     * @var ArticlesRepositoryInterface
     */
    protected $repository;

    /**
     * @var AbstractFactoryInterface
     */
    protected $factory;

    /**
     * AbstractProvider constructor.
     * @param ArticlesRepositoryInterface $repository
     * @param AbstractFactoryInterface $factory
     */
    public function __construct(ArticlesRepositoryInterface $repository = null, AbstractFactoryInterface $factory = null)
    {
        $this->repository = $repository;
        $this->factory = $factory;
    }

    public function getArticlesRepository(): ArticlesRepositoryInterface
    {
        return $this->repository;
    }

    /**
     * @param ArticlesRepositoryInterface $repository
     * @return AbstractProvider
     */
    public function setArticlesRepository(ArticlesRepositoryInterface $repository): AbstractProvider
    {
        $this->repository = $repository;
        return $this;
    }

    /**
     * @return AbstractFactoryInterface
     */
    public function getFactory(): AbstractFactoryInterface
    {
        return $this->factory;
    }

    /**
     * @param AbstractFactoryInterface $factory
     * @return AbstractProvider
     */
    public function setFactory(AbstractFactoryInterface $factory): AbstractProvider
    {
        $this->factory = $factory;
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return $this->repository->count();
    }


}