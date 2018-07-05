<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 11:57
 */

namespace App\Article;


use App\Entity\Article;

interface ArticlesRepositoryInterface extends \Countable
{
    public function find(int $id): ?Article;
    public function findOneBy(array $criteria): ?Article;
    public function findAll(): array;
    public function findLastFiveArticles(): array;
    public function findSpecialArticles(): array;
    public function findSpotlightArticles(): array;
    public function findArticlesSuggestions($articleId, $categoryId): array;

}