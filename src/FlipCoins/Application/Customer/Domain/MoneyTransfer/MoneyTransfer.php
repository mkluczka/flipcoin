<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer;

use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Shared\Domain\Events;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

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

        return $this;
    }
}
