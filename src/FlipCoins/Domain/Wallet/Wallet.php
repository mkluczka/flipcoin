<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Wallet;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;

final class Wallet
{
    public function __construct(
        public readonly Customer $owner,
        private Money $amount,
    ) {
    }

    public function subtract(Money $amount): void
    {
        $this->amount = $this->amount->subtract($amount);
    }

    public function add(Money $amount): void
    {
        $this->amount = $this->amount->add($amount);

    }

    public function amountEquals(self $other): bool
    {
        return $this->amount->equals($other->amount);
    }
}
