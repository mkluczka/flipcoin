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
        public Money $amount
    ) {
    }

    public function apply(): Events
    {
        $this->sourceWallet->subtract($this->amount);
        $this->targetWallet->add($this->amount);

        $events = new Events(
            new MoneyTransferred(
                $this->sourceWallet->owner,
                $this->targetWallet->owner,
                $this->amount
            )
        );

        if ($this->sourceWallet->amountEquals($this->targetWallet)) {
            $events = $events->append(
                new Offer1Applied($this->sourceWallet->owner),
                new Offer1Applied($this->targetWallet->owner),
            );
        }

        return $events;
    }
}
