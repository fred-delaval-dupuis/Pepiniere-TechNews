<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 12:06
 */

namespace App\Article\Factory;


use App\Entity\Article;

Interface AbstractFactoryInterface
{
    public function createArticle($args): Article;
}