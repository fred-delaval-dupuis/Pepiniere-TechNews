<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 12:16
 */

namespace App\Article;


use App\Provider\ProviderInterface;

abstract class AbstractArticlesRepository implements ArticlesRepositoryInterface
{
    /**
     * @var ProviderInterface[]
     */
    protected $providers;

    /**
     * AbstractArticlesRepository constructor.
     * @param ProviderInterface[]|null $providers
     */
    public function __construct(array $providers = null)
    {
        $this->providers = $providers;
    }

    /**
     * @return ProviderInterface[]
     */
    public function getProviders(): array
    {
        return $this->providers;
    }

    /**
     * @param ProviderInterface[] $providers
     * @return AbstractArticlesRepository
     */
    public function setProviders(iterable $providers): AbstractArticlesRepository
    {
        $this->providers = $providers;
        return $this;
    }

    public function addProvider(ProviderInterface $provider)
    {
        if (array_key_exists(get_class($provider), $this->providers)) {
            return;
        }

        $this->providers[get_class($provider)] = $provider;
        $provider->setArticlesRepository($this);
    }

    public function setupProviders()
    {
        foreach ($this->providers as $provider) {
            $provider->setArticlesRepository($this);
        }
    }

    /**
     * @inheritDoc
     */
    public function count()
    {
        return count($this->providers);
    }


}