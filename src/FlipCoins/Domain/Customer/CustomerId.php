<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer;

use MKluczka\FlipCoins\Domain\Customer\Exception\InvalidCustomerName;

final readonly class CustomerId implements \Stringable
{
    public function __construct(public string $customerName)
    {
        if (mb_strlen($customerName) < 2 || mb_strlen($customerName) > 64) {
            throw new InvalidCustomerName();
        }
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->customerName;
    }

    public function equals(self $other): bool
    {
        return $this->customerName === $other->customerName;
    }
}
