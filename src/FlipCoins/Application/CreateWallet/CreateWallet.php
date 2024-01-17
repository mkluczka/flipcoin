<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\CreateWallet;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;

final class CreateWallet
{
    public function __construct(
        public readonly Customer $customer,
        public readonly Money $initialAmount,
    ) {
    }
}
