<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared\Domain;

interface DomainEventDispatcher
{
    public function dispatchRecordedEvents(): void;
}
