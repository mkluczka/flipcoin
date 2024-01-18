<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer;

use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Shared\Events;

final readonly class MoneyTransfer
{
    public function __construct(
        public Wallet $sourceWallet,
        public Wallet $targetWallet,
        public Money $amount,
        private Events $events,
    ) {
    }

    public function apply(): self
    {
        $this->sourceWallet->subtract($this->amount);
        $this->targetWallet->add($this->amount);

        $this->events->record(
            new MoneyTransferred(
                $this->sourceWallet->owner,
                $this->targetWallet->owner,
                $this->amount
            )
        );

        if ($this->sourceWallet->amountEquals($this->targetWallet)) {
            $this->sourceWallet->applyOffer1();
            $this->targetWallet->applyOffer1();
        }

        return $this;
    }
}
