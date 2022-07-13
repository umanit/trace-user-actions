<?php

namespace Umanit\TraceUserActions\Event\Subscriber;

use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Umanit\TraceUserActions\Event\UserActionEvent;

final class AddActionSubscriber implements EventSubscriberInterface
{
    /** @var LoggerInterface */
    protected $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            UserActionEvent::class => 'addAction',
        ];
    }

    public function addAction(UserActionEvent $event): void
    {
        $extra = [];
        if (null !== $event->getUser()) {
            $extra['user'] = $this->getUserIdentifier($event->getUser());
        }

        $this->logger->info($event->getAction(), $extra);
    }

    private function getUserIdentifier(UserInterface $user): string
    {
        if (method_exists($user, 'getUserIdentifier')) {
            return $user->getUserIdentifier();
        }

        return $user->getUsername();
    }
}
