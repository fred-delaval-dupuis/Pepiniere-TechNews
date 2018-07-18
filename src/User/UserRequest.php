<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 15:31
 */

namespace App\User;

use Symfony\Component\Validator\Constraints as Assert;

class UserRequest
{
    /**
     * @Assert\Length(
     *     min = 2,
     *     max = 50,
     *     minMessage = "Votre prénom doit contenir au moins {{ limit }} caractères",
     *     maxMessage = "Votre prénom ne doit pas contenir plus de {{ limit }} caractères"
     * )
     * @var string
     */
    private $firstName;

    /**
     * @Assert\Length(
     *     min = 2,
     *     max = 50,
     *     minMessage = "Votre nom doit contenir au moins {{ limit }} caractères",
     *     maxMessage = "Votre nom ne doit pas contenir plus de {{ limit }} caractères"
     * )
     * @var string
     */
    private $lastName;

    /**
     * @Assert\NotBlank(message="Saisissez votre e-mail")
     * @Assert\Length(max="80", maxMessage="Le mot de passe ne doit pas dépasser {{ limit }} caractères")
     * @Assert\Email(message = "L'email '{{ value }}' n'est pas valide.",)
     * @var string
     */
    private $email;

    /**
     * @Assert\Length(
     *     min = 8,
     *     max = 20,
     *     minMessage = "Le mot de passe doit contenir au moins {{ limit }} caractères",
     *     maxMessage = "Le mot de passe ne dot pas dépasser {{ limit }} caractères")
     * )
     * @var string
     */
    private $password;

    /**
     * @var \DateTime
     */
    private $registrationDate;

    /**
     * @var array
     */
    private $roles;

    /**
     * @var string
     * @Assert\Locale(canonicalize = true)
     */
    private $locale;

    /**
     * UserRequest constructor.
     * @param string $firstName
     * @param string $lastName
     * @param string $email
     * @param string $password
     * @param \DateTime $registrationDate
     * @param string $locale
     * @param array $roles
     */
    public function __construct(
        string $firstName = null,
        string $lastName = null,
        string $email = null,
        string $password = null,
        \DateTime $registrationDate = null,
        array $roles = ['ROLE_USER'],
        string $locale = null
    ) {
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->email = $email;
        $this->password = $password;
        $this->registrationDate = $registrationDate ?: new \DateTime();
        $this->roles = $roles;
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     * @return UserRequest
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     * @return UserRequest
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return UserRequest
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return UserRequest
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getRegistrationDate()
    {
        return $this->registrationDate;
    }

    /**
     * @param \DateTime $registrationDate
     * @return UserRequest
     */
    public function setRegistrationDate($registrationDate)
    {
        $this->registrationDate = $registrationDate;
        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     * @return UserRequest
     */
    public function setRoles(array $roles)
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * Gets the username (email)
     * @return string
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     * @return UserRequest
     */
    public function setLocale(string $locale): UserRequest
    {
        $this->locale = $locale;
        return $this;
    }
}
