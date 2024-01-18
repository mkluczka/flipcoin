<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer\Event;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;

final readonly class Offer2Applied
{
    private const string FIRST_PLACE_AMOUNT = '10';
    private const string SECOND_PLACE_AMOUNT = '5';
    private const string THIRD_PLACE_AMOUNT = '2';

    public function __construct(
        public CustomerId $customer,
        public Money $offerAmount
    ) {
    }

    public static function firstPlace(CustomerId $customer): self
    {
        return self::build($customer, self::FIRST_PLACE_AMOUNT);
    }

    private static function build(CustomerId $customer, string $decimalAmount): self
    {
        return new self($customer, Money::fromDecimal($decimalAmount));
    }

    public static function secondPlace(CustomerId $customer): self
    {
        return self::build($customer, self::SECOND_PLACE_AMOUNT);
    }

    public static function thirdPlace(CustomerId $customer): self
    {
        return self::build($customer, self::THIRD_PLACE_AMOUNT);
    }
}
