<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\MoneyTransfer\Event;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Shared\DomainEvent;

final readonly class MoneyTransferred implements DomainEvent
{
    public function __construct(
        public CustomerId $sourceCustomer,
        public Money $sourceBalanceAfter,
        public CustomerId $targetCustomer,
        public Money $targetBalanceAfter,
        public Money $transactionAmount,
    ) {
    }
}
