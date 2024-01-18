<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Wallet;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Shared\Events;

final readonly class WalletFactory
{
    public function __construct(private Events $events)
    {
    }

    public function build(CustomerId $customerId, Money $initialAmount): Wallet
    {
        return new Wallet($customerId, $initialAmount, $this->events);
    }
}
