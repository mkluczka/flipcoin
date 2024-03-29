<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Application\TransferMoney;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerRepository;
use MKluczka\FlipCoins\Shared\Domain\DomainEventDispatcher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class TransferMoneyHandler
{
    public function __construct(
        private CustomerRepository $customerRepository,
        private DomainEventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(TransferMoney $command): void
    {
        $sourceCustomer = $this->customerRepository->getCustomer($command->sourceCustomer);
        $targetCustomer = $this->customerRepository->getCustomer($command->targetCustomer);

        $sourceCustomer->transferMoneyTo($targetCustomer, $command->amount);

        $this->eventDispatcher->dispatchRecordedEvents();
    }
}
