<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Application\TransferMoney;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

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
