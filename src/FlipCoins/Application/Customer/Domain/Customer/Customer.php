<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Domain\Customer;

use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\MoneyTransferFactory;
use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Shared\Domain\Events;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

class Customer
{
    public function __construct(
        public readonly CustomerId $customerId,
        private ?Wallet $wallet,
        private readonly MoneyTransferFactory $moneyTransferFactory,
        private readonly Events $events,
    ) {
    }

    public function transferMoneyTo(self $other, Money $amount): void
    {
        $this->moneyTransferFactory
            ->build($this->wallet, $other->wallet, $amount)
            ->apply();
    }

    public function createWallet(Money $initialAmount): void
    {
        if (null !== $this->wallet) {
            throw new \RuntimeException('Customer already has wallet');
        }

        $this->wallet = new Wallet($this->customerId, $initialAmount);

        $this->events->record(new WalletCreated($this->customerId, $initialAmount));
    }

    public function addAmount(Money $amount): void
    {
        $this->wallet->add($amount);
    }
}
