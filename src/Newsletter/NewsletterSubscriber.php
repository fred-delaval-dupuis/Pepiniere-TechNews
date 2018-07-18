<?php
/**
 * Created by PhpStorm.
 * User: Etudiant0
 * Date: 03/07/2018
 * Time: 12:02
 */

namespace App\Newsletter;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class NewsletterSubscriber implements EventSubscriberInterface
{

    /**
     * @inheritDoc
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => 'onKernelRequest',
            KernelEvents::RESPONSE => 'onKernelResponse',
        ];
    }

    public function onKernelRequest(GetResponseEvent $event)
    {
        if (! $event->isMasterRequest() || $event->getRequest()->isXmlHttpRequest()) {
            return;
        }

        $session = $event->getRequest()->getSession();

        $session->set('nbViews', $session->get('nbViews', 0) + 1);

        if ($session->get('nbViews') === 4) {
            $session->set('showModal', true);
        }
    }

    public function onKernelResponse(FilterResponseEvent $event)
    {
        if (! $event->isMasterRequest() || $event->getRequest()->isXmlHttpRequest()) {
            return;
        }

        $session = $event->getRequest()->getSession();
        if ($session->get('nbViews') >= 4) {
            $session->set('showModal', false);
        }
    }
}
