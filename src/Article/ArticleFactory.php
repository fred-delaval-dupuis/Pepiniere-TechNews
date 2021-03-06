<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 11:23
 */

namespace App\Article;

use App\Entity\Article;

class ArticleFactory
{
    public function createFromArticleRequest(ArticleRequest $articleRequest): Article
    {
        return new Article(
            $articleRequest->getTitle(),
            $articleRequest->getContent(),
            $articleRequest->getFeaturedImage(),
            $articleRequest->getSpecial(),
            $articleRequest->getSpotlight(),
            $articleRequest->getCreatedAt(),
            $articleRequest->getCategory(),
            $articleRequest->getAuthor(),
            $articleRequest->getSlug(),
            $articleRequest->getStatus()
        );
    }

    public function createRequestFromArticle(Article $article): ArticleRequest
    {
        return (new ArticleRequest($article->getAuthor()))
            ->setTitle($article->getTitle())
            ->setContent($article->getContent())
            ->setFeaturedImage($article->getFeaturedImage())
            ->setSpecial($article->getSpecial())
            ->setSpotlight($article->getSpotlight())
            ->setCreatedAt($article->getCreatedAt())
            ->setCategory($article->getCategory())
            ->setSlug($article->getSlug())
            ->setStatus($article->getStatus())
        ;
    }
}
