<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\CreateWallet;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;

final readonly class CreateWallet
{
    public function __construct(
        public CustomerId $customerId,
        public Money $initialAmount,
    ) {
    }
}
