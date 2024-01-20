<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Offer;

use MKluczka\FlipCoins\Domain\Money\Money;

class OfferAwardFactory
{
    /** @var string[] */
    private const array OFFER2_AWARDS = ['10', '5', '2'];

    public function offer1(): OfferAward
    {
        return new OfferAward('Offer1', Money::fromDecimal('10'));
    }

    public function offer2(int $place): OfferAward
    {
        return new OfferAward('Offer2', Money::fromDecimal(self::OFFER2_AWARDS[$place]));
    }
}
