<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Customer;

use MKluczka\FlipCoins\Domain\MoneyTransfer\MoneyTransferFactory;
use MKluczka\FlipCoins\Domain\MoneyTransfer\TransferHistory;
use MKluczka\FlipCoins\Domain\Wallet\WalletFactory;
use MKluczka\FlipCoins\Shared\Events;

final readonly class CustomerFactory
{
    public function __construct(
        private Events $events,
        private MoneyTransferFactory $moneyTransferFactory,
        private WalletFactory $walletFactory,
    ) {
    }

    public function new(CustomerId $customerId): Customer
    {
        return new Customer(
            $customerId,
            null,
            new TransferHistory([]),
            $this->moneyTransferFactory,
            $this->walletFactory,
            $this->events,
        );
    }
}
