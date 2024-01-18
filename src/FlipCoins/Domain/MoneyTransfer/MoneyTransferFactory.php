<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer;

use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Shared\Events;

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
