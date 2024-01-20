<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Offer\Offer2\Ranking;

use MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate\Offer2Candidate;

class Offer2RankingService
{
    /**
     * @param array<Offer2Candidate> $customers
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
     * @param array<Offer2Candidate> $customers
     * @return array<Offer2Candidate>
     */
    private function reorderCustomers(array $customers): array
    {
        usort($customers, fn(Offer2Candidate $left, Offer2Candidate $right) => $left->compareOffer2($right));

        return $customers;
    }
}
