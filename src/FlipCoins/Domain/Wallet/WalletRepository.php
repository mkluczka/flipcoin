<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Wallet;

use MKluczka\FlipCoins\Domain\Customer\Customer;

interface WalletRepository
{
    public function getCollection(): WalletCollection;

    public function getForCustomer(Customer $customer): Wallet;
}
