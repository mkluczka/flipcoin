<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer;

use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\Offer1Applied;
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
                $this->sourceWallet->getAmount(),
                $this->targetWallet->owner,
                $this->targetWallet->getAmount(),
                $this->amount
            )
        );

        if ($this->sourceWallet->amountEquals($this->targetWallet)) {
            $this->events->record(
                new Offer1Applied(
                    $this->sourceWallet->owner,
                    $this->targetWallet->owner,
                )
            );
        }

        return $this;
    }
}
