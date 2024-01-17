<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared;

final class Events
{
    public readonly array $events;

    public function __construct(object ...$events)
    {
        $this->events = $events;
    }

    public function append(object ...$events): self
    {
        return new self(...$this->events, ... $events);
    }
}
