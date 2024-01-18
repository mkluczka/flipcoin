<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer2;

use MKluczka\FlipCoins\Domain\Customer\CustomerRepository;
use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class Offer2Handler
{
    public function __construct(
        private CustomerRepository $repository,
        private DomainEventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(Offer2 $command): void
    {
        $this->repository
            ->getCustomerCollection()
            ->offer2();

        $this->eventDispatcher->dispatchRecordedEvents();
    }
}
