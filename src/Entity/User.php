<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\EquatableInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 */
class User implements UserInterface, EquatableInterface
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
    private $firstName;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=64)
     */
    private $password;

    /**
     * @ORM\Column(type="datetime")
     */
    private $registrationDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastConnectionDate;

    /**
     * @ORM\Column(type="array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Article", mappedBy="author")
     * @ORM\JoinColumn(nullable=false)
     * @var Article[]
     */
    private $articles;

    /**
     * @ORM\Column(type="string", length=5)
     */
    private $locale;

    /**
     * User constructor.
     * @param $id
     * @param $firstName
     * @param $lastName
     * @param $email
     * @param $password
     * @param $registrationDate
     * @param $lastConnectionDate
     * @param $roles
     * @param Article[] $articles
     * @param $locale
     */
    public function __construct($id = null, $firstName = null, $lastName = null, $email = null, $password = null, $registrationDate = null, $lastConnectionDate = null, $roles = null, array $articles = null, $locale = null)
    {
        $this->id = $id;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->registrationDate = $registrationDate;
        $this->lastConnectionDate = $lastConnectionDate;
        $this->roles = $roles ?: [];
        $this->articles = $articles ?: new ArrayCollection();
        $this->locale = $locale;
    }


    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return null|string
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return User
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return User
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return User
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return User
     */
    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Article[]
     */
    public function getArticles(): array
    {
        return $this->articles;
    }

    /**
     * @param Article[] $articles
     * @return User
     */
    public function setArticles(array $articles): User
    {
        $this->articles = $articles;
        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getRegistrationDate(): ?\DateTimeInterface
    {
        return $this->registrationDate;
    }

    /**
     * @param \DateTimeInterface $registrationDate
     * @return User
     */
    public function setRegistrationDate(\DateTimeInterface $registrationDate): self
    {
        $this->registrationDate = $registrationDate;

        return $this;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getLastConnectionDate(): ?\DateTimeInterface
    {
        return $this->lastConnectionDate;
    }

    /**
     * @param \DateTimeInterface $lastConnectionDate
     * @return User
     */
    public function setLastConnectionDate(\DateTimeInterface $lastConnectionDate): self
    {
        $this->lastConnectionDate = $lastConnectionDate;

        return $this;
    }

    /**
     * @return array|null
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return User
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Adds a role
     * @param $role
     * @return User
     */
    public function addRole($role): self
    {
        if (! in_array($role, $this->roles)) {
            $this->roles[] = $role;
        }
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function eraseCredentials()
    {
    }

    /**
     * @param UserInterface $user
     * @return bool
     */
    public function isEqualTo(UserInterface $user)
    {
        if (!$user instanceof User) {
            return false;
        }

        if ($this->password !== $user->getPassword()) {
            return false;
        }

        if ($this->email !== $user->getUsername()) {
            return false;
        }

        return true;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @inheritDoc
     */
    public function getSalt()
    {
        return null;
    }

    /**
     * @return mixed
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param mixed $locale
     * @return User
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
        return $this;
    }
}
