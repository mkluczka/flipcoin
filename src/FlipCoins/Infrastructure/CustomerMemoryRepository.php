<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Infrastructure;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Customer\CustomerFactory;
use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Customer\CustomerRepository;
use MKluczka\FlipCoins\Domain\Customer\CustomersCollection;
use MKluczka\FlipCoins\Domain\Customer\Offer2\Offer2RankingService;

final class CustomerMemoryRepository implements CustomerRepository
{
    /**
     * @var array<Customer>
     */
    private array $customers = [];


    public function __construct(
        private readonly CustomerFactory $customerFactory,
        private readonly Offer2RankingService $rankingService,
    ) {
    }

    #[\Override] public function getCustomerCollection(): CustomersCollection
    {
        return new CustomersCollection(
            $this->customers,
            $this->rankingService,
        );
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
