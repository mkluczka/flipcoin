<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\ReadModel\Statement;

use MKluczka\FlipCoins\Domain\Customer\Customer;

final class StatementReadModel
{
    /**
     * @var array<string, array<string>>
     */
    private array $data = [];

    /**
     * @return array<string>.
     */
    public function getForCustomer(Customer $customer): array
    {
        return $this->data[(string) $customer] ?? [];
    }

    public function addCustomerStatement(Customer $customer, string $statement): void
    {
        $this->data[(string) $customer][] = $statement;
    }
}
