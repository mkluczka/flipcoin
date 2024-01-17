<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer\Event;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;

final readonly class MoneyTransferred
{
    public function __construct(
        public Customer $sourceCustomer,
        public Customer $targetCustomer,
        public Money $amount,
    ) {
    }
}
