<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\ReadModel\Statement;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;

final class StatementReadModel
{
    /**
     * @var array<string, array<string>>
     */
    private array $data = [];

    /**
     * @return array<string>.
     */
    public function getForCustomer(CustomerId $customer): array
    {
        return $this->data[(string) $customer] ?? [];
    }

    public function addCustomerStatement(CustomerId $customer, string $statement): void
    {
        $this->data[(string) $customer][] = $statement;
    }
}
