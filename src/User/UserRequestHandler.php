<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 29/06/2018
 * Time: 15:31
 */

namespace App\User;


use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class UserRequestHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var UserFactory
     */
    private $factory;

    /**
     * @var EventDispatcherInterface
     */
    private $dispatcher;

    /**
     * UserRequestHandler constructor.
     * @param EntityManagerInterface $em
     * @param UserFactory $factory
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(EntityManagerInterface $em, UserFactory $factory, EventDispatcherInterface $dispatcher)
    {
        $this->em = $em;
        $this->factory = $factory;
        $this->dispatcher = $dispatcher;
    }

    public function handle(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();

        $this->dispatcher->dispatch(UserEvents::USER_CREATED, new UserEvent($user));

        return $user;
    }

    public function registerAsUser(UserRequest $request)
    {
        $user = $this->factory->createUserFromRequest($request);

        return $this->handle($user);
    }
}