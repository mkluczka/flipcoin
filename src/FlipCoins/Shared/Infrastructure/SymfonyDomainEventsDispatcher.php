<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared\Infrastructure;

use MKluczka\FlipCoins\Shared\Domain\DomainEventDispatcher;
use MKluczka\FlipCoins\Shared\Domain\Events;
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
        while ($event = $this->events->next()) {
            $this->eventDispatcher->dispatch($event);
        }
    }
}
