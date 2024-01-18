<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer;

interface CustomerRepository
{
    public function getCustomerCollection(): CustomersCollection;

    public function getCustomer(CustomerId $customerId): Customer;

    public function newCustomer(CustomerId $customerId): Customer;
}
