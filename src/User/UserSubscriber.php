<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 03/07/2018
 * Time: 16:07
 */

namespace App\User;

use App\Entity\Newsletter;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var SessionInterface
     */
    private $session;

    /**
     * UserLoginSubscriber constructor.
     * @param EntityManagerInterface $em
     * @param SessionInterface $session
     */
    public function __construct(EntityManagerInterface $em, SessionInterface $session)
    {
        $this->em = $em;
        $this->session = $session;
    }

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => ['onSecurityInteractiveLogin', 15],
            KernelEvents::REQUEST => ['onKernelRequest', 15],
            UserEvents::USER_CREATED => 'onCreatedUser'
        ];
    }

    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        $user = $event->getAuthenticationToken()->getUser();

        if ($user instanceof User || $user instanceof UserRequest) {
            $user->setLastConnectionDate(new \DateTime());
            $this->em->flush();

            // Setting the locale
            if (null !== $user->getLocale()) {
                $this->session->set('_locale', $user->getLocale());
            }
        }
    }

    public function onCreatedUser(UserEvent $event)
    {
        $user = $event->getUser();

        $newsletter = new Newsletter();
        $newsletter->setEmail($user->getEmail());

        $this->em->persist($newsletter);
        $this->em->flush();
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        $request = $event->getRequest();

        if (null !== $this->session->get('_locale')) {
            $request->setLocale($this->session->get('_locale'));
        }
    }
}
