<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer\Event;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Offer\OfferAward;
use MKluczka\FlipCoins\Shared\DomainEvent;

final readonly class Offer2Applied implements DomainEvent
{
    public function __construct(
        public CustomerId $customerId,
        public OfferAward $offer,
    ) {
    }
}
