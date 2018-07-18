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
        $this->data = $this->articlesRepo->getStats();
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
        return $this->data[ArticlesRepository::class];
    }

    public function getDoctrineProvider()
    {
        return $this->data[DoctrineProvider::class];
    }

    public function getYamlProvider()
    {
        return $this->data[YamlProvider::class];
    }

    public function getData()
    {
        return $this->data;
    }
}
