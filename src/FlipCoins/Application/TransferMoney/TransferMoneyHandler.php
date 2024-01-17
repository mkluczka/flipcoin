<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\TransferMoney;

use MKluczka\FlipCoins\Domain\MoneyTransfer\MoneyTransfer;
use MKluczka\FlipCoins\Domain\Wallet\WalletRepository;
use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class TransferMoneyHandler
{
    public function __construct(
        private WalletRepository $walletRepository,
        private DomainEventDispatcher $eventDispatcher,
    ) {
    }
    public function __invoke(TransferMoney $command): void
    {
        $sourceWallet = $this->walletRepository->getForCustomer($command->sourceCustomer);
        $targetWallet = $this->walletRepository->getForCustomer($command->targetCustomer);

        $moneyTransfer = new MoneyTransfer($sourceWallet, $targetWallet, $command->amount);
        $result = $moneyTransfer->apply();

        $this->eventDispatcher->dispatch($result);
    }
}
