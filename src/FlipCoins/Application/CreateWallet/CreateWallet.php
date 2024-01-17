<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\CreateWallet;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;

final readonly class CreateWallet
{
    public function __construct(
        public Customer $customer,
        public Money $initialAmount,
    ) {
    }
}
