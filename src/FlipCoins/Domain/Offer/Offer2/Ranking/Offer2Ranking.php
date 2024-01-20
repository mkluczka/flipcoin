<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Offer\Offer2\Ranking;

use MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate\Offer2Candidate;

final readonly class Offer2Ranking
{
    public function __construct(
        public ?Offer2Candidate $firstPlace,
        public ?Offer2Candidate $secondPlace,
        public ?Offer2Candidate $thirdPlace,
    ) {
    }

    /**
     * @return array<Offer2Candidate>
     */
    public function all(): array
    {
        return array_filter([
            $this->firstPlace,
            $this->secondPlace,
            $this->thirdPlace
        ]);
    }
}
