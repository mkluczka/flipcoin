<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\ReadModel\Overview;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

class OverviewReadModel
{
    /**
     * @var array<string,Money>
     */
    private array $data = [];

    /**
     * @return array<int, array<int, string>>
     */
    public function getAll(): array
    {
        return array_map(
            fn(string $customer, Money $amount) => [$customer, (string) $amount],
            array_keys($this->data),
            array_values($this->data),
        );
    }

    public function getForCustomer(CustomerId $customer): Money
    {
        return $this->data[(string) $customer] ?? Money::zero();
    }

    public function subtract(CustomerId $customer, Money $amount): void
    {
        $this->setForCustomer(
            $customer,
            $this->getForCustomer($customer)->subtract($amount),
        );
    }

    public function add(CustomerId $customer, Money $amount): void
    {
        $this->setForCustomer(
            $customer,
            $this->getForCustomer($customer)->add($amount),
        );
    }

    public function setForCustomer(CustomerId $customer, Money $amount): void
    {
        $this->data[(string) $customer] = $amount;
    }
}
