<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 26/06/2018
 * Time: 09:53
 */

namespace App\Provider;

use App\Article\ArticlesRepositoryInterface;
use App\Article\Factory\AbstractFactoryInterface;
use App\Entity\Article;
use App\Strategy\StrategyInterface;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class YamlProvider extends AbstractProvider
{

    /**
     * @var iterable
     */
    private $articles;

    /**
     * @inheritDoc
     */
    public function __construct(ArticlesRepositoryInterface $repository = null, AbstractFactoryInterface $factory = null)
    {
        parent::__construct($repository, $factory);
        $this->articles = $this->getArticles();
    }


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
        $result = [];

        foreach ($this->articles as $article) {
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
    public function find(int $id): ?Article
    {
        foreach ($this->articles as $article) {
            if ($article['id'] === $id) {
                return $this->factory->createArticle($article);
            }
        }
        return null;
    }


    public function findOneBy(array $criteria): ?Article
    {
        // We need slugs, etc...
        $articles = $this->factory->createArticles($this->articles);

        foreach ($articles as $article) {
            $found = true;
            foreach ($criteria as $criterion => $value) {
//                dump([$criterion => $value]);
                if (! $found) {
                    break;
                }
                /* @var $article Article */
                $method = 'get' . camel_case($criterion);
                if (method_exists($article, $method)) {
                    $found &= $article->$method() === $value;
                }
            }
            if ($found) {
//                return $this->factory->createArticle($article);
                return $article;
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
        $this->sortDate($this->articles);

        $sliced = array_slice($this->articles, 0, 5);
        return $this->createArticles($sliced);
    }

    public function findSpecialArticles(): array
    {
        $specials = [];

        foreach ($this->articles as $article) {
            if (isset($article['special']) && $article['special']) {
                $specials[] = $article;
            }
        }

        return $this->createArticles($specials);
    }

    public function findSpotlightArticles(): array
    {
        $spotlights = [];

        foreach ($this->articles as $article) {
            if (isset($article['spotlight']) && $article['spotlight']) {
                $spotlights[] = $article;
            }
        }

        return $this->createArticles($spotlights);
    }

    public function findArticlesSuggestions($articleId, $categoryId): array
    {
        $suggestions = [];

        foreach ($this->articles as $article) {
            if ($article['id'] !== $articleId && $article['category']['id']) {
                $suggestions[] = $article;
            }
        }

        $this->sortDate($suggestions);
        $sliced = array_slice($suggestions, 0, 3);
        return $this->createArticles($sliced);
    }


    private function createArticles($articles)
    {
        $result = [];
        foreach ($articles as $article) {
            $result[] = $this->factory->createArticle($article);
        }
        return $result;
    }

    public function setStrategy(StrategyInterface $strategy)
    {
        $this->factory->setStrategy($strategy);
    }

    private function sortDate(array &$articles)
    {
        usort($articles, function ($a, $b) {
            $dateA = \DateTime::createFromFormat('Y-m-d H:i:s', $a['datecreation']);
            $dateB = \DateTime::createFromFormat('Y-m-d H:i:s', $b['datecreation']);
            return $dateA <=> $dateB;
        });
    }

    /**
     * @inheritDoc
     */
    public function count(): int
    {
        return count($this->articles);
    }
}
