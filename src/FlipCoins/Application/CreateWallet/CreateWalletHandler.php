<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\CreateWallet;

use MKluczka\FlipCoins\Domain\Wallet\WalletRepository;
use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class CreateWalletHandler
{
    public function __construct(
        private WalletRepository $repository,
        private DomainEventDispatcher $eventDispatcher,
    ) {
    }
    public function __invoke(CreateWallet $command): void
    {
        $result = $this->repository
            ->getCollection()
            ->addWallet($command->customer, $command->initialAmount);

        $this->eventDispatcher->dispatch($result);
    }
}
