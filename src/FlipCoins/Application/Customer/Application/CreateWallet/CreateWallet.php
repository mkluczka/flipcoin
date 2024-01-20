<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Application\CreateWallet;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

final readonly class CreateWallet
{
    public function __construct(
        public CustomerId $customerId,
        public Money $initialAmount,
    ) {
    }
}
