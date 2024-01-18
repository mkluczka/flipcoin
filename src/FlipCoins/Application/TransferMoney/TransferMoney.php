<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\TransferMoney;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;

final readonly class TransferMoney
{
    public function __construct(
        public CustomerId $sourceCustomer,
        public CustomerId $targetCustomer,
        public Money $amount,
    )
    {
    }
}
