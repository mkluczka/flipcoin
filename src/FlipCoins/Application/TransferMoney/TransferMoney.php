<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\TransferMoney;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;

final class TransferMoney
{
    public function __construct(
        public readonly Customer $sourceCustomer,
        public readonly Customer $targetCustomer,
        public readonly Money $amount,
    )
    {
    }
}
