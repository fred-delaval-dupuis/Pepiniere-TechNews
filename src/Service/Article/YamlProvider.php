<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 26/06/2018
 * Time: 09:53
 */

namespace App\Service\Article;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlProvider
{
    /**
     * @var KernelInterface
     */
    private $kernel;

    /**
     * YamlProvider constructor.
     * @param KernelInterface $kernel
     */
    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    public function getArticles(): array
    {
//        try {
//            $filename = __DIR__ . DIRECTORY_SEPARATOR . 'articles.yml';
//            return Yaml::parseFile($filename)['data'];
//        } catch (ParseException $exception) {
//            printf('Unable to parse the YAML string: %s', $exception->getMessage());
//        }

        return unserialize(file_get_contents($this->kernel->getCacheDir() . '/yaml-article.php'));
    }

    public function getArticlesFromCategory(string $category): array
    {
        $articles = $this->getArticles();
        $result = [];

        foreach ($articles as $article) {
            if (strtolower($article['category']['title']) === strtolower($category)) {
                $result[] = $article;
            }
        }

        return $result;
    }
}