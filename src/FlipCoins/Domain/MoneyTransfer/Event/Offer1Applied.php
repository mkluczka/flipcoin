<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer\Event;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;

final class Offer1Applied
{
    public function __construct(
        public CustomerId $customer,
        public Money $offerAmount,
    ) {
    }
}
