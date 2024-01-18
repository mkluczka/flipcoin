<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer\Offer2;

use MKluczka\FlipCoins\Domain\Customer\Customer;

class Offer2RankingService
{
    /**
     * @param array<Customer> $customers
     * @return Offer2Ranking
     */
    public function getCustomersRanking(array $customers): Offer2Ranking
    {
        $orderedCustomers = $this->reorderCustomers($customers);

        return new Offer2Ranking(
            $orderedCustomers[0] ?? null,
            $orderedCustomers[1] ?? null,
            $orderedCustomers[2] ?? null,
        );
    }

    /**
     * @param array<Customer> $customers
     * @return array<Customer>
     */
    private function reorderCustomers(array $customers): array
    {
        usort($customers, fn(Customer $left, Customer $right) => $left->compareOffer2($right));

        return $customers;
    }
}
