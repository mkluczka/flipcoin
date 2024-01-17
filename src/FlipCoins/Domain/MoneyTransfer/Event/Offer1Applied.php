<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer\Event;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;

final class Offer1Applied
{
    public readonly Money $offerAmount;

    public function __construct(public Customer $customer)
    {
        $this->offerAmount = Money::fromDecimal('10');
    }
}
