<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared\Domain\Money\Exception;

final class InvalidMoneyFormat extends \DomainException
{
    public function __construct(string $decimalAmount)
    {
        parent::__construct("Invalid money format: `$decimalAmount`");
    }
}
