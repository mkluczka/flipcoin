<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Infrastructure;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Customer\CustomerFactory;
use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Customer\CustomerRepository;

final class CustomerMemoryRepository implements CustomerRepository
{
    /**
     * @var array<Customer>
     */
    private array $customers = [];


    public function __construct(
        private readonly CustomerFactory $customerFactory,
    ) {
    }

    #[\Override] public function getCustomer(CustomerId $customerId): Customer
    {
        $key = (string) $customerId;

        if (!isset($this->customers[$key])) {
            throw new \RuntimeException('Customer not found');
        }

        return $this->customers[$key];
    }

    #[\Override] public function newCustomer(CustomerId $customerId): Customer
    {
        $this->customers[(string) $customerId] = $this->customerFactory->new($customerId);

        return $this->getCustomer($customerId);
    }
}
