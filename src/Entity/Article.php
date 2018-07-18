<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ArticleRepository")
 */
class Article
{
    const NB_PER_PAGE = 2;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $featuredImage;

    /**
     * @ORM\Column(type="boolean")
     */
    private $special;

    /**
     * @ORM\Column(type="boolean")
     */
    private $spotlight;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Category", inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     * @var Category
     */
    private $category;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="articles", fetch="EAGER")
     * @ORM\JoinColumn(nullable=false)
     *
     * @var User
     */
    private $author;

    /**
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(length=128, unique=true)
     */
    private $slug;

    /**
     * @ORM\Column(type="array")
     */
    private $status;

    /**
     * Article constructor.
     * @param $title
     * @param $content
     * @param $featuredImage
     * @param $special
     * @param $spotlight
     * @param $createdAt
     * @param Category $category
     * @param User $author
     * @param null $slug
     * @param null $status
     */
    public function __construct($title = null, $content = null, $featuredImage = null, $special = null, $spotlight = null, $createdAt = null, Category $category = null, User $author = null, $slug = null, $status = null)
    {
        $this->title = $title;
        $this->content = $content;
        $this->featuredImage = $featuredImage;
        $this->special = $special;
        $this->spotlight = $spotlight;
        $this->createdAt = $createdAt ?: new \DateTime();
        $this->category = $category;
        $this->author = $author;
        $this->slug = $slug;
        $this->status = $status;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     * @return Article
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * @param string $content
     * @return Article
     */
    public function setContent(string $content): self
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
     * @return Article
     */
    public function setFeaturedImage($featuredImage): self
    {
        $this->featuredImage = $featuredImage;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSpecial(): ?bool
    {
        return $this->special;
    }

    /**
     * @param bool $special
     * @return Article
     */
    public function setSpecial(bool $special): self
    {
        $this->special = $special;

        return $this;
    }

    /**
     * @return bool|null
     */
    public function getSpotlight(): ?bool
    {
        return $this->spotlight;
    }

    /**
     * @param bool $spotlight
     * @return Article
     */
    public function setSpotlight(bool $spotlight): self
    {
        $this->spotlight = $spotlight;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    /**
     * @param \DateTimeInterface $createdAt
     * @return Article
     */
    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory(): ?Category
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Article
     */
    public function setCategory(Category $category): Article
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return User
     */
    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     * @return Article
     */
    public function setAuthor(User $author): Article
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
     * @return Article
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
        return $this;
    }

    public function getStatus(): ?array
    {
        return $this->status;
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

        return $this;
    }
}
