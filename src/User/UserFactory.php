<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 15:31
 */

namespace App\User;


use App\Entity\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    /**
     * UserFactory constructor.
     * @param UserPasswordEncoderInterface $encoder
     */
    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function createUserFromRequest(UserRequest $request): User
    {
        $user = new User(
            null,
            $request->getFirstName(),
            $request->getLastName(),
            $request->getEmail(),
            $request->getPassword(),
            $request->getRegistrationDate(),
            null,
            $request->getRoles(),
            null
        );

        $user->setPassword($this->encoder->encodePassword($user, $user->getPassword()));

        return $user;
    }

    public function createRequestFromUser(User $user): UserRequest
    {
        return new UserRequest(
            $user->getFirstName(),
            $user->getLastName(),
            $user->getEmail(),
            $user->getPassword(),
            $user->getRegistrationDate(),
            $user->getRoles()
        );
    }
}