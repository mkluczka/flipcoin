<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Customer\CustomerRepository;
use MKluczka\FlipCoins\Domain\Offer\Event\OfferAwardApplied;
use MKluczka\FlipCoins\Domain\Offer\OfferAward;
use MKluczka\FlipCoins\Shared\Events;

final readonly class OfferAwardsService
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private Events $events,
    ) {
    }

    public function grantAward(CustomerId $customerId, OfferAward $award): void
    {
        $this->customerRepository
            ->getCustomer($customerId)
            ->addAmount($award->amount);

        $this->events->record(new OfferAwardApplied($customerId, $award));
    }
}
