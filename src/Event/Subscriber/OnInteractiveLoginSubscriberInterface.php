<?php

namespace Umanit\TraceUserActions\Event\Subscriber;

use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

interface OnInteractiveLoginSubscriberInterface
{
    public function onInteractiveLogin(InteractiveLoginEvent $event): void;
}
