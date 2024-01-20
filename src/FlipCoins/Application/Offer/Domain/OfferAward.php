<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Domain;

use MKluczka\FlipCoins\Shared\Domain\Money\Money;

final readonly class OfferAward implements \Stringable
{
    public function __construct(
        public string $name,
        public Money $amount,
    ) {
    }

    public function __toString(): string
    {
        return "$this->name ($this->amount)";
    }
}
