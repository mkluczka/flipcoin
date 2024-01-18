<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer\Event;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;

final readonly class MoneyTransferred
{
    public function __construct(
        public CustomerId $sourceCustomer,
        public CustomerId $targetCustomer,
        public Money $amount,
    ) {
    }
}
