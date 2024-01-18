<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer;

use MKluczka\FlipCoins\Domain\Customer\Offer2\Offer2RankingService;
use MKluczka\FlipCoins\Shared\Offer;

class CustomersCollection
{
    /**
     * @param array<Customer> $customers
     */
    public function __construct(
        private readonly array $customers,
        private readonly Offer2RankingService $rankingService,
    ) {
    }

    public function offer2(): void
    {
        $customersRanking = $this->rankingService->getCustomersRanking($this->customers);

        $customersRanking->firstPlace?->offer2(Offer::offer2FirstPlace());
        $customersRanking->secondPlace?->offer2(Offer::offer2SecondPlace());
        $customersRanking->thirdPlace?->offer2(Offer::offer2ThirdPlace());
    }
}
