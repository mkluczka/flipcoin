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

    public function equals(self $other): bool
    {
        return $this->customerName === $other->customerName;
    }

    #[\Override]
    public function __toString(): string
    {
        return $this->customerName;
    }
}
