<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared;

final class Events
{
    /**
     * @var array<object>
     */
    private array $events;

    public function __construct(object ...$events)
    {
        $this->events = $events;
    }

    public function record(object $event): void
    {
        $this->events[] = $event;
    }

    public function getNext(): ?object
    {
        if (empty($this->events)) {
            return null;
        }

        return array_shift($this->events);
    }
}
