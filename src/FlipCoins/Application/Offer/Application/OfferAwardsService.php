<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Application;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerRepository;
use MKluczka\FlipCoins\Application\Offer\Domain\Event\OfferAwardApplied;
use MKluczka\FlipCoins\Application\Offer\Domain\OfferAward;
use MKluczka\FlipCoins\Shared\Domain\Events;

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
