<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 26/06/2018
 * Time: 09:53
 */

namespace App\Service\Article;

use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlProvider
{
    public function getArticles(): array
    {
        try {
            $filename = __DIR__ . DIRECTORY_SEPARATOR . 'articles.yml';
            return Yaml::parseFile($filename)['data'];
        } catch (ParseException $exception) {
            printf('Unable to parse the YAML string: %s', $exception->getMessage());
        }
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