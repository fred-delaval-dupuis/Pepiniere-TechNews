<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 10:36
 */

namespace App\Article;

use App\Entity\Article;
use App\Entity\Category;
use App\Entity\User;
use Symfony\Component\Validator\Constraints as Assert;

class ArticleRequest
{

    /**
     * @Assert\NotBlank(message="Veuillez renseigner ce champ")
     * @Assert\Length(max="255", maxMessage="Le titre ne dot pas dépasser 255 caractères")
     * @var string
     */
    private $title;

    /**
     * @Assert\NotBlank(message="Veuillez renseigner ce champ")
     * @var string
     */
    private $content;

    /**
     * @Assert\Image(maxSize="2M", maxSizeMessage="Le poids de l'image ne doit pas dépasser {{ limit }}", mimeTypesMessage="L'image n'a pas une extension valide")
     *
     * @var mixed
     */
    private $featuredImage;

    /**
     * @var bool
     */
    private $special;

    /**
     * @var bool
     */
    private $spotlight;

    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @Assert\NotNull(message="Veuillez renseigner ce champ")
     *
     * @var Category
     */
    private $category;

    /**
     * @Assert\NotNull(message="Veuillez renseigner ce champ")
     *
     * @var User
     */
    private $author;

    /**
     * @var string
     */
    private $slug;

    /**
     * ArticleRequest constructor.
     * @param $author
     */
    public function __construct($author)
    {
        $this->author = $author;
        $this->createdAt = new \DateTime();
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
     * @return ArticleRequest
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     * @return ArticleRequest
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFeaturedImage()
    {
        return $this->featuredImage;
    }

    /**
     * @param mixed $featuredImage
     * @return ArticleRequest
     */
    public function setFeaturedImage($featuredImage)
    {
        $this->featuredImage = $featuredImage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpecial()
    {
        return $this->special;
    }

    /**
     * @param mixed $special
     * @return ArticleRequest
     */
    public function setSpecial($special)
    {
        $this->special = $special;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSpotlight()
    {
        return $this->spotlight;
    }

    /**
     * @param mixed $spotlight
     * @return ArticleRequest
     */
    public function setSpotlight($spotlight)
    {
        $this->spotlight = $spotlight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return ArticleRequest
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     * @return ArticleRequest
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     * @return ArticleRequest
     */
    public function setAuthor($author)
    {
        $this->author = $author;
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
     * @return ArticleRequest
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function updateArticle(Article $article)
    {
        $article->setTitle($this->getTitle());
        $article->setContent($this->getContent());
        $article->setCategory($this->getCategory());
        $article->setSpotlight($this->getSpotlight());
        $article->setSpecial($this->getSpecial());
    }

}