<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer;

use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Shared\Domain\Events;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

final readonly class MoneyTransferFactory
{
    public function __construct(private Events $events)
    {
    }

    public function build(Wallet $source, Wallet $target, Money $amount): MoneyTransfer
    {
        return new MoneyTransfer($source, $target, $amount, $this->events);
    }
}
