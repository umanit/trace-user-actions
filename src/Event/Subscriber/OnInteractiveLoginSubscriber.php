<?php

namespace Umanit\TraceUserActions\Event\Subscriber;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Http\SecurityEvents;
use Umanit\TraceUserActions\Event\UserActionEvent;

final class OnInteractiveLoginSubscriber implements OnInteractiveLoginSubscriberInterface, EventSubscriberInterface
{
    /** @var EventDispatcherInterface */
    private $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            SecurityEvents::INTERACTIVE_LOGIN => 'onInteractiveLogin',
        ];
    }

    public function onInteractiveLogin(InteractiveLoginEvent $event): void
    {
        $user = null !== $event->getAuthenticationToken() ? $event->getAuthenticationToken()->getUser() : null;

        $this->eventDispatcher->dispatch(new UserActionEvent('User login', $user));
    }
}
