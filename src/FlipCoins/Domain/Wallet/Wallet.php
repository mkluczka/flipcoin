<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Wallet;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Customer\Event\Offer2Applied;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\Offer1Applied;
use MKluczka\FlipCoins\Shared\Events;
use MKluczka\FlipCoins\Shared\Offer;

final class Wallet
{
    public readonly \DateTimeImmutable $createdAt;

    public function __construct(
        public readonly CustomerId $owner,
        private Money $amount,
        private readonly Events $events,
    ) {
        $this->createdAt = new \DateTimeImmutable();
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

    public function compareOffer2(self $other): int
    {
        if ($this->amount !== $other->amount) {
            return $this->amount <=> $other->amount;
        }

        return $this->createdAt->getTimestamp() <=> $other->createdAt->getTimestamp();
    }

    public function applyOffer1(): void
    {
        $offerAmount = Offer::offer1();

        $this->add($offerAmount);

        $this->events->record(new Offer1Applied($this->owner, $offerAmount));
    }

    public function applyOffer2(Money $offerAmount): void
    {
        $this->add($offerAmount);

        $this->events->record(new Offer2Applied($this->owner, $offerAmount));
    }
}
