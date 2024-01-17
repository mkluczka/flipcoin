<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Money;

use MKluczka\FlipCoins\Domain\Money\Exception\InvalidMoneyFormat;
use MKluczka\FlipCoins\Domain\Money\Exception\MoneyAmountCannotBeNagative;

final class Money implements \Stringable
{
    private function __construct(public readonly int $amount)
    {
        if ($this->amount < 0) {
            throw new MoneyAmountCannotBeNagative();
        }
    }

    public static function fromDecimal(string $decimalAmount): self
    {
        if (!preg_match('/^\d+(\.\d{1,4})?$/', $decimalAmount)) {
            throw new InvalidMoneyFormat($decimalAmount);
        }

        return new self((int) round((float) $decimalAmount * 1e4));
    }

    public static function zero(): self
    {
        return new self(0);
    }

    public function subtract(self $other): self
    {
        return new self($this->amount - $other->amount);
    }

    public function add(self $other): self
    {
        return new self($this->amount + $other->amount);
    }

    public function equals(self $other): bool
    {
        return $this->amount === $other->amount;
    }

    public function __toString(): string
    {
        return (string) ($this->amount / 10000);
    }
}
