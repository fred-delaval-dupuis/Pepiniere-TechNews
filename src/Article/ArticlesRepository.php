<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 14:34
 */

namespace App\Article;

use App\Entity\Article;
use App\Provider\ProviderInterface;

class ArticlesRepository extends AbstractArticlesRepository
{
    public function find(int $id): ?Article
    {
        $articles = [];

        foreach ($this->providers as $provider) {
            $article = $provider->find($id);
            if (null !== $article) {
                $articles[] = $article;
            }
        }

        if (empty($this->unique($articles))) {
            return null;
        } else {
            return $this->unique($articles)[0];
        }
    }

    public function findOneBy(array $criteria): ?Article
    {
        $articles = [];

        foreach ($this->providers as $provider) {
            $article = $provider->findOneBy($criteria);
            if (null !== $article) {
                $articles[] = $article;
            }
        }

        if (empty($this->unique($articles))) {
            return null;
        } else {
            return $this->unique($articles)[0];
        }
    }

    public function findAll(): array
    {
        $articles = [[]];

        foreach ($this->providers as $provider) {
            $articles[] = $provider->findAll();
        }

        $articles = \array_merge(...$articles);

        $this->dateSort($articles);

        return $this->unique($articles);
    }

    public function findLastFiveArticles(): array
    {
        $articles = [[]];

        foreach ($this->providers as $provider) {
            $articles[] = $provider->findLastFiveArticles();
        }

        $articles = \array_merge(...$articles);

        $this->dateSort($articles);
        $sliced = \array_slice($articles, 0, 4);

        return $this->unique($sliced);
    }

    public function findSpecialArticles(): array
    {
        $articles = [[]];

        foreach ($this->providers as $provider) {
            $articles[] = $provider->findSpecialArticles();
        }

        $articles = \array_merge(...$articles);

        $this->dateSort($articles);

        return $this->unique($articles);
    }

    public function findSpotlightArticles(): array
    {
        $articles = [[]];

        foreach ($this->providers as $provider) {
            $articles[] = $provider->findSpotlightArticles();
        }

        $articles = \array_merge(...$articles);

        $this->dateSort($articles);

        return $this->unique($articles);
    }

    public function findArticlesSuggestions($articleId, $categoryId): array
    {
        $articles = [[]];

        foreach ($this->providers as $provider) {
            $articles[] = $provider->findArticlesSuggestions($articleId, $categoryId);
        }

        $articles = \array_merge(...$articles);

        $this->dateSort($articles);

        return $this->unique($articles);
    }


    private function dateSort(array &$articles, string $direction = 'DESC')
    {
        if ($direction === 'ASC') {
            usort($articles, function (Article $a, Article $b) {
                return $a->getCreatedAt() <=> $b->getCreatedAt();
            });
        } else {
            usort($articles, function (Article $a, Article $b) {
                return $b->getCreatedAt() <=> $a->getCreatedAt();
            });
        }
    }

    private function unique(array $articles)
    {
        $uniqueArticles = [];
        $countArticles = \count($articles);

        if ($countArticles > 1) {
            $uniqueArticles[] = $articles[0];
            for ($i = 1; $i < $countArticles-1; $i++) {
                $article = $articles[$i];

                $unique = true;

                $countUniqueArticles = \count($uniqueArticles);
                for ($j = 0; $j < $countUniqueArticles; $j++) {
                    if ($uniqueArticles[$j]->getId() === $article->getId()) {
                        $unique = false;
                        break;
                    }
                }

                if ($unique) {
                    $uniqueArticles[] = $article;
                }
            }

            return $uniqueArticles;
        }

        return $articles;
    }

    public function getStats()
    {
        $stats = [];

        $stats[\get_class($this)] = $this->count();

        /* @var ProviderInterface $provider */
        foreach ($this->getProviders() as $provider) {
            $stats[\get_class($provider)] = $provider->count();
        }

        return $stats;
    }
}
