<?php

namespace Umanit\TraceUserActions\Event\Subscriber;

use Psr\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Http\Event\LogoutEvent;
use Umanit\TraceUserActions\Event\UserActionEvent;

final class OnLogoutSubscriber implements OnLogoutSubscriberInterface, EventSubscriberInterface
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
            LogoutEvent::class => 'onLogout',
        ];
    }

    public function onLogout(LogoutEvent $event): void
    {
        $user = null !== $event->getToken() ? $event->getToken()->getUser() : null;

        $this->eventDispatcher->dispatch(new UserActionEvent('User logout', $user));
    }
}
