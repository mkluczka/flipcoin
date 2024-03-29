<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Application\CreateWallet;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerRepository;
use MKluczka\FlipCoins\Shared\Domain\DomainEventDispatcher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateWalletHandler
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private DomainEventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(CreateWallet $command): void
    {
        $this->customerRepository
            ->newCustomer($command->customerId)
            ->createWallet($command->initialAmount);

        $this->eventDispatcher->dispatchRecordedEvents();
    }
}
