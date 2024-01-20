<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared\Domain;

final class Events
{
    /**
     * @var array<DomainEvent>
     */
    private array $events = [];

    public function record(DomainEvent $event): void
    {
        $this->events[] = $event;
    }

    public function next(): ?object
    {
        if (empty($this->events)) {
            return null;
        }

        return array_shift($this->events);
    }
}
