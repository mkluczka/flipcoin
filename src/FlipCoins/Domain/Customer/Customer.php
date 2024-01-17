<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer;

use MKluczka\FlipCoins\Domain\Customer\Exception\InvalidCustomerName;

final readonly class Customer implements \Stringable
{
    public function __construct(public string $name)
    {
        if (mb_strlen($name) < 2 || mb_strlen($name) > 64) {
            throw new InvalidCustomerName();
        }
    }

    public function __toString(): string
    {
        return $this->name;
    }

    public function equals(self $other): bool
    {
        return $this->name === $other->name;
    }
}
