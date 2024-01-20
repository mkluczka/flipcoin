<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Event;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Shared\Domain\DomainEvent;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

final readonly class WalletCreated implements DomainEvent
{
    public function __construct(
        public CustomerId $walletOwner,
        public Money $initialAmount,
    ) {
    }
}
