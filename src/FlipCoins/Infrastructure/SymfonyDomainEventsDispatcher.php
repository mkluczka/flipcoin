<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Infrastructure;

use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use MKluczka\FlipCoins\Shared\Events;
use Psr\EventDispatcher\EventDispatcherInterface;

final readonly class SymfonyDomainEventsDispatcher implements DomainEventDispatcher
{
    public function __construct(
        private EventDispatcherInterface $eventDispatcher,
        private Events $events,
    ) {
    }

    #[\Override]
    public function dispatchRecordedEvents(): void
    {
        while ($event = $this->events->getNext()) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
