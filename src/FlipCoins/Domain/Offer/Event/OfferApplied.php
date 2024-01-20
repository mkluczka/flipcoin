<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Offer\Event;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Offer\Offer;
use MKluczka\FlipCoins\Shared\DomainEvent;

final readonly class OfferApplied implements DomainEvent
{
    public function __construct(
        public CustomerId $customerId,
        public Offer $offer,
    ) {
    }
}
