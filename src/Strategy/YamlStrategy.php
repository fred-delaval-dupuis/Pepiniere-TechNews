<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 04/07/2018
 * Time: 14:26
 */

namespace App\Strategy;


use App\Controller\HelperTrait;
use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;

class YamlStrategy implements StrategyInterface
{
    use HelperTrait;

    public function createArticle($args): Article
    {
        try {
            $article = new Article(
                $args['title'],
                $args['content'],
                $args['featuredimage'],
                $args['special'],
                $args['spotlight'],
                $args['datecreation'],
                new Category($args['category']['id'], $args['category']['title'], $this->slugify($args['category']['title'])),
                new User($args['author']['id'], $args['author']['firstname'], $args['author']['lastname'],$args['author']['email']),
                $this->slugify($args['title'])
            );
            $article->setId($args['id']);
            return $article;
        } catch(\Exception $e) {
            return null;
        }
    }

}