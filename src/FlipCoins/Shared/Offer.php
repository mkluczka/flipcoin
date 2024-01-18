<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared;

use MKluczka\FlipCoins\Domain\Money\Money;

final readonly class Offer
{
    public static function offer2FirstPlace(): Money
    {
        return Money::fromDecimal('10');
    }

    public static function offer2SecondPlace(): Money
    {
        return Money::fromDecimal('5');
    }

    public static function offer2ThirdPlace(): Money
    {
        return Money::fromDecimal('2');
    }

    public static function offer1(): Money
    {
        return Money::fromDecimal('10');
    }
}
