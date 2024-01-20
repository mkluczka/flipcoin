<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Domain\Event;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Application\Offer\Domain\OfferAward;
use MKluczka\FlipCoins\Shared\Domain\DomainEvent;

final readonly class OfferAwardApplied implements DomainEvent
{
    public function __construct(
        public CustomerId $customerId,
        public OfferAward $award,
    ) {
    }
}
