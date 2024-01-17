<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Wallet\Event;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;

final class WalletCreated
{
    public function __construct(
        public readonly Customer $walletOwner,
        public readonly Money $initialAmount,
    ) {
    }
}
