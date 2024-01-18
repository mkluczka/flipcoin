<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer\Offer2;

use MKluczka\FlipCoins\Domain\Customer\Customer;

final readonly class Offer2Ranking
{
    public function __construct(
        public ?Customer $firstPlace,
        public ?Customer $secondPlace,
        public ?Customer $thirdPlace,
    ) {
    }
}
