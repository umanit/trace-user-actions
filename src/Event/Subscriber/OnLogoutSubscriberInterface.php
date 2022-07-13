<?php

namespace Umanit\TraceUserActions\Event\Subscriber;

use Symfony\Component\Security\Http\Event\LogoutEvent;

interface OnLogoutSubscriberInterface
{
    public function onLogout(LogoutEvent $event): void;
}
