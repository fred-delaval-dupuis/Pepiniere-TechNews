<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 13:18
 */

namespace App\Category;

use Symfony\Component\Validator\Constraints as Assert;


class CategoryRequest
{
    /**
     * @Assert\NotBlank()
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $slug;

    /**
     * @var Article[]
     */
    private $articles;

    /**
     * CategoryRequest constructor.
     * @param $title
     * @param $slug
     * @param $articles
     */
    public function __construct($title = null, $slug = null, $articles = null)
    {
        $this->title = $title;
        $this->slug = $slug;
        $this->articles = $articles;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     * @return CategoryRequest
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     * @return CategoryRequest
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->articles;
    }

    /**
     * @param mixed $articles
     * @return CategoryRequest
     */
    public function setArticles($articles)
    {
        $this->articles = $articles;
        return $this;
    }

}