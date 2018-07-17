<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 17/07/2018
 * Time: 09:53
 */

namespace App\DataCollector;


use App\Article\ArticlesRepository;
use App\Provider\DoctrineProvider;
use App\Provider\YamlProvider;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

class ArticleProviderCollector extends DataCollector
{
    /**
     * @var ArticlesRepository
     */
    private $articlesRepo;

    /**
     * ArticleProviderCollector constructor.
     * @param ArticlesRepository $articlesRepo
     */
    public function __construct(ArticlesRepository $articlesRepo)
    {
        $this->articlesRepo = $articlesRepo;
    }

    /**
     * @inheritDoc
     */
    public function collect(Request $request, Response $response, \Exception $exception = null)
    {
        $tempProviders = $this->articlesRepo->getProviders();
        foreach ($tempProviders as $provider) {
            $providers[get_class($provider)] = $provider;
        }
        $doctrineProvider = $providers[DoctrineProvider::class];
        $yamlProvider = $providers[YamlProvider::class];

        $this->data = [
            'providers_count' => $this->articlesRepo->count(),
            'doctrine_provider' => $doctrineProvider->count(),
            'yaml_provider' => $yamlProvider->count(),
        ];
    }

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return 'app.provider_collector';
    }

    /**
     * @inheritDoc
     */
    public function reset()
    {
        $this->data = [];
    }

    public function getProvidersCount()
    {
        return $this->data['providers_count'];
    }

    public function getDoctrineProvider()
    {
        return $this->data['doctrine_provider'];
    }

    public function getYamlProvider()
    {
        return $this->data['yaml_provider'];
    }
}