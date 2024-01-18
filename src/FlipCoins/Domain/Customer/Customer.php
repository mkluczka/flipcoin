<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer;

use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\MoneyTransfer\MoneyTransferFactory;
use MKluczka\FlipCoins\Domain\MoneyTransfer\TransferHistory;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Domain\Wallet\WalletFactory;
use MKluczka\FlipCoins\Shared\Events;

class Customer
{
    public function __construct(
        public readonly CustomerId $customerId,
        private ?Wallet $wallet,
        private readonly TransferHistory $transferHistory,
        private readonly MoneyTransferFactory $moneyTransferFactory,
        private readonly WalletFactory $walletFactory,
        private readonly Events $events,
    ) {
    }

    public function compareOffer2(self $other): int
    {
        if ($this->transferHistory->lengthEquals($other->transferHistory)) {
            return $this->transferHistory->compareOffer2($other->transferHistory);
        }

        return $this->wallet->compareOffer2($other->wallet);
    }

    public function offer2(Money $offerAmount): void
    {
        $this->wallet->applyOffer2($offerAmount);
    }

    public function transferMoneyTo(self $other, Money $amount): void
    {
        $moneyTransfer = $this->moneyTransferFactory
            ->build($this->wallet, $other->wallet, $amount)
            ->apply();

        $this->transferHistory->addMoneyTransfer($moneyTransfer);
    }

    public function createWallet(Money $initialAmount): void
    {
        if (null !== $this->wallet) {
            throw new \RuntimeException('Customer already has wallet');
        }

        $this->wallet = $this->walletFactory->build($this->customerId, $initialAmount);

        $this->events->record(new WalletCreated($this->customerId, $initialAmount));
    }
}
