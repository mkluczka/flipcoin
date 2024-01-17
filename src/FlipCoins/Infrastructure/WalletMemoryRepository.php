<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Infrastructure;

use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Domain\Wallet\WalletCollection;
use MKluczka\FlipCoins\Domain\Wallet\WalletRepository;

final readonly class WalletMemoryRepository implements WalletRepository
{
    private WalletCollection $walletCollection;

    public function __construct()
    {
        $this->walletCollection = new WalletCollection([]);
    }

    #[\Override]
    public function getCollection(): WalletCollection
    {
        return $this->walletCollection;
    }

    #[\Override] public function getForCustomer(Customer $customer): Wallet
    {
        return $this->walletCollection->getWallets()[(string) $customer]
            ?? new  Wallet($customer, Money::fromDecimal('0'));
    }
}
