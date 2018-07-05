<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 12:08
 */

namespace App\Strategy;

use App\Entity\Article;

Interface StrategyInterface
{
    public function createArticle($args): ?Article;
    public function createArticles($articles): iterable;
}