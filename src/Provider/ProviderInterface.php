<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 11:57
 */

namespace App\Provider;


use App\Article\ArticlesRepositoryInterface;

Interface ProviderInterface extends ArticlesRepositoryInterface
{
    public function getArticlesRepository(): ArticlesRepositoryInterface;
    public function setArticlesRepository(ArticlesRepositoryInterface $repository);
}