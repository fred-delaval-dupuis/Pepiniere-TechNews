<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 26/06/2018
 * Time: 09:53
 */

namespace App\Provider;

use App\Entity\Article;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlProvider extends AbstractProvider
{
    public function getArticles(): array
    {
        try {
            $filename = __DIR__ . DIRECTORY_SEPARATOR . '../Service/Article' . DIRECTORY_SEPARATOR . 'articles.yml';
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

    /**
     * Finds an article by id
     * @param int $id
     * @return Article|null
     */
    public function find(int $id): Article
    {
        $articles = $this->getArticles();
        foreach ($articles as $article) {
            if ($article['id'] === $id) {
                return $this->factory->createArticle($article);
            }
        }
        return null;
    }


    public function findOneBy(array $criteria): Article
    {
        $articles = $this->getArticles();
        foreach ($articles as $article) {
            $found = true;
            foreach ($criteria as $criterion => $value) {
                if ( ! $found) break;
                if (isset($article[$criterion])) {
                    $found &= $article[$criterion] === $value;
                }
            }
            if ($found) {
                return $this->factory->createArticle($article);
            }
        }
        return null;
    }

    public function findAll(): array
    {
        return $this->createArticles($this->getArticles());
    }

    public function findLastFiveArticles(): array
    {
        $articles = $this->getArticles();

        usort($articles, function($a, $b) {
           $dateA = \DateTime::createFromFormat('Y-m-d H:i:s', $a['datecreation']);
           $dateB = \DateTime::createFromFormat('Y-m-d H:i:s', $b['datecreation']);
           return $dateA <=> $dateB;
        });

        $sliced = array_slice($articles, 0, 4);
        return $this->createArticles($sliced);
    }

    public function findSpecialArticles(): array
    {
        $specials = [];
        $articles = $this->getArticles();
        foreach ($articles as $article) {
            if (isset($article['special']) && $article['special']) {
                $specials[] = $article;
            }
        }

        return $this->createArticles($specials);
    }

    public function findSpotlightArticles(): array
    {
        $spotlights = [];
        $articles = $this->getArticles();
        foreach ($articles as $article) {
            if (isset($article['spotlight']) && $article['spotlight']) {
                $spotlights[] = $article;
            }
        }

        return $this->createArticles($spotlights);
    }

    private function createArticles($articles)
    {
        $result = [];
        foreach ($articles as $article) {
            $result[] = $this->factory->createArticle($article);
        }
        return $result;
    }

}