<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared;

interface DomainEventDispatcher
{
    public function dispatch(object ...$events): void;
}
