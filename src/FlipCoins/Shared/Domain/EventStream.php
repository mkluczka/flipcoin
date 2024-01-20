<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared\Domain;

class EventStream
{
    /** @var array<object> */
    private array $events = [];

    public function addEvent(object $event): void
    {
        $this->events[] = $event;
    }

    /**
     * @return object[]
     */
    public function getEvents(): array
    {
        return $this->events;
    }
}
