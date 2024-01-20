<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Domain\Customer;

use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\MoneyTransferFactory;
use MKluczka\FlipCoins\Shared\Domain\Events;

final readonly class CustomerFactory
{
    public function __construct(
        private Events $events,
        private MoneyTransferFactory $moneyTransferFactory,
    ) {
    }

    public function new(CustomerId $customerId): Customer
    {
        return new Customer(
            $customerId,
            null,
            $this->moneyTransferFactory,
            $this->events,
        );
    }
}
