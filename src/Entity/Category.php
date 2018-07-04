<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $title;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="category")
     * @ORM\JoinColumn(nullable=false)
     * @var Article[]
     */
    private $articles;

    /**
     * Category constructor.
     * @param $id
     * @param $title
     * @param $slug
     * @param Article[] $articles
     */
    public function __construct($id = null, $title = null, $slug = null, array $articles = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->slug = $slug;
        $this->articles = $articles ?: new ArrayCollection();
    }


    /**
     * Gets the id
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the title
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * Sets the title
     * @param string $title
     * @return Category
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Gets the slug
     * @return null|string
     */
    public function getSlug(): ?string
    {
        return $this->slug;
    }

    /**
     * Sets the slug
     * @param string $slug
     * @return Category
     */
    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Article[]
     */
    public function getArticles(): Collection
    {
        return $this->articles;
    }

    /**
     * @param Article[] $articles
     */
    public function setArticles(array $articles): void
    {
        $this->articles = $articles;
    }


}
