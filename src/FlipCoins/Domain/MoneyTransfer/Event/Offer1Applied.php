<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer\Event;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Shared\DomainEvent;

final readonly class Offer1Applied implements DomainEvent
{
    public function __construct(
        public CustomerId $sourceCustomer,
        public CustomerId $targetCustomerId,
    ) {
    }
}
