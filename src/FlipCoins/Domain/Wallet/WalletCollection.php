<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Wallet;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Shared\Events;

class WalletCollection
{
    /**
     * @param array<Wallet> $wallets
     */
    public function __construct(private array $wallets)
    {
    }

    public function addWallet(Customer $customer, Money $initialAmount): ?Events
    {
        if (array_key_exists((string) $customer, $this->wallets)) {
            return new Events();
        }

        $this->wallets[(string) $customer] = new Wallet($customer, $initialAmount);

        return new Events(new WalletCreated($customer, $initialAmount));
    }

    public function getWallets(): array
    {
        return $this->wallets;
    }
}
