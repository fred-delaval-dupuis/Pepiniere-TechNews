<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 12:07
 */

namespace App\Article\Factory;

use App\Entity\Article;
use App\Strategy\StrategyInterface;

abstract class AbstractFactory implements AbstractFactoryInterface
{
    /**
     * @var StrategyInterface
     */
    protected $strategy;

    /**
     * AbstractFactory constructor.
     * @param StrategyInterface $strategy
     */
    public function __construct(StrategyInterface $strategy)
    {
        $this->strategy = $strategy;
    }

    /**
     * @return StrategyInterface
     */
    public function getStrategy(): StrategyInterface
    {
        return $this->strategy;
    }

    /**
     * @param StrategyInterface $strategy
     * @return AbstractFactory
     */
    public function setStrategy(StrategyInterface $strategy): AbstractFactory
    {
        $this->strategy = $strategy;
        return $this;
    }

    public function createArticle($args): ?Article
    {
        return $this->strategy->createArticle($args);
    }

    public function createArticles($articles): iterable
    {
        return $this->strategy->createArticles($articles);
    }
}
