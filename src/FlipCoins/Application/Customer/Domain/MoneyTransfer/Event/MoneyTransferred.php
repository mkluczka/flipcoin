<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\Event;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Shared\Domain\DomainEvent;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

final readonly class MoneyTransferred implements DomainEvent
{
    public function __construct(
        public CustomerId $sourceCustomerId,
        public Money $sourceBalanceAfter,
        public CustomerId $targetCustomerId,
        public Money $targetBalanceAfter,
        public Money $transactionAmount,
    ) {
    }
}
