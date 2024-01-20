<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Domain\Customer;

interface CustomerRepository
{
    public function getCustomer(CustomerId $customerId): Customer;

    public function newCustomer(CustomerId $customerId): Customer;
}
