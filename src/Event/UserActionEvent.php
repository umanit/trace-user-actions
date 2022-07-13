<?php

namespace Umanit\TraceUserActions\Event;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Contracts\EventDispatcher\Event;

final class UserActionEvent extends Event
{
    /** @var string */
    private $action;

    /** @var UserInterface|null */
    private $user;

    public function __construct(string $action, ?UserInterface $user = null)
    {
        $this->action = $action;
        $this->user = $user;
    }

    public function getAction(): string
    {
        return $this->action;
    }

    public function getUser(): ?UserInterface
    {
        return $this->user;
    }
}
