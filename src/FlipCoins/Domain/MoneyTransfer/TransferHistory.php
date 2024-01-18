<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer;

final class TransferHistory
{
    /**
     * @param array<MoneyTransfer> $entries
     */
    public function __construct(private array $entries)
    {
    }

    public function lengthEquals(self $other): bool
    {
        return $this->getLength() === $other->getLength();
    }

    public function compareOffer2(self $other): int
    {
        return $this->getLength() <=> $other->getLength();
    }

    public function getLength(): int
    {
        return count($this->entries);
    }

    public function addMoneyTransfer(MoneyTransfer $moneyTransfer): void
    {
        $this->entries[] = $moneyTransfer;
    }
}
