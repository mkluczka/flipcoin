<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Offer;

use MKluczka\FlipCoins\Domain\Money\Money;

class OfferFactory
{
    public function offer1(): Offer
    {
        return new Offer('Offer1', Money::fromDecimal('10'));
    }

    public function offer2(string $offerAmount): Offer
    {
        return new Offer('Offer2', Money::fromDecimal($offerAmount));
    }
}
