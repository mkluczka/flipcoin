<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Domain\Offer2\Candidate;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

final class Offer2Candidate
{
    public \DateTimeImmutable $createdAt;
    private Money $accountBalance;
    private int $transfersCount;

    public function __construct(public readonly CustomerId $customerId)
    {
        $this->accountBalance = Money::zero();
        $this->transfersCount = 0;
        $this->createdAt = new \DateTimeImmutable();
    }

    public function addTransferCount(): self
    {
        $this->transfersCount++;

        return $this;
    }

    public function changeBalance(Money $balance): self
    {
        $this->accountBalance = $balance;

        return $this;
    }

    public function compareOffer2(self $other): int
    {
        if ($this->transfersCount !== $other->transfersCount) {
            return $this->transfersCount <=> $other->transfersCount;
        }

        if ($this->accountBalance !== $other->accountBalance) {
            return $this->accountBalance <=> $other->accountBalance;
        }

        return $this->createdAt->getTimestamp() <=> $other->createdAt->getTimestamp();
    }
}
