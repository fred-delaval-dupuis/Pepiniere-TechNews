<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 14:34
 */

namespace App\Article;


use App\Entity\Article;

class ArticlesRepository extends AbstractArticlesRepository
{

    public function find(int $id): Article
    {
        $articles= [];

        foreach ($this->providers as $provider) {
            $articles = array_merge($articles, [$provider->find($id)]);
        }
        // Gestion des priorités des providers ?
        return $articles[0];
    }

    public function findOneBy(array $criteria): Article
    {
        $articles = [];

        foreach ($this->providers as $provider) {
            $articles = array_merge($articles, [$provider->findOneBy($criteria)]);
        }

        return $articles;
    }

    public function findAll(): array
    {
        $articles = [];

        foreach ($this->providers as $provider) {
            $articles = array_merge($articles, $provider->findAll());
        }

        $this->dateSort($articles);

        return $articles;
    }

    public function findLastFiveArticles(): array
    {
        $articles = [];

        foreach ($this->providers as $provider) {
            $articles = array_merge($articles, $provider->findLastFiveArticles());
        }

        $this->dateSort($articles);

        return array_slice($articles, 0, 4);
    }

    public function findSpecialArticles(): array
    {
        $articles = [];

        foreach ($this->providers as $provider) {
            $articles = array_merge($articles, $provider->findSpecialArticles());
        }

        $this->dateSort($articles);
        return $articles;
    }

    public function findSpotlightArticles(): array
    {
        $articles = [];

        foreach ($this->providers as $provider) {
            $articles = array_merge($articles, $provider->findSpotlightArticles());
        }

        $this->dateSort($articles);
        return $articles;
    }

    private function dateSort(array $articles, string $direction = 'DESC')
    {
        if ($direction === 'ASC') {
            usort($articles, function(Article $a, Article $b) {
                return $b->getCreatedAt() <=> $a->getCreatedAt();
            });
        } else {
            usort($articles, function(Article $a, Article $b) {
                return $a->getCreatedAt() <=> $b->getCreatedAt();
            });
        }
    }

}