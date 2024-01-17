<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Infrastructure;

use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use Psr\EventDispatcher\EventDispatcherInterface;

final class SymfonyDomainEventsDispatcher implements DomainEventDispatcher
{
    public function __construct(private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    #[\Override] public function dispatch(object ...$events)
    {
        foreach ($events as $event) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
