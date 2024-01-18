<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Wallet\Event;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;

final readonly class WalletCreated
{
    public function __construct(
        public CustomerId $walletOwner,
        public Money $initialAmount,
    ) {
    }
}
