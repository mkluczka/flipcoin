<?php

declare(strict_types=1);

namespace Tests\Utils\ItemGenerator;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Customer\Event\Offer2Applied;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\Offer1Applied;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Shared\Offer;

final readonly class EventGenerator
{
    public static function walletCreated(string $customerId, string $amount): WalletCreated
    {
        return new WalletCreated(new CustomerId($customerId), Money::fromDecimal($amount));
    }

    public static function moneyTransferred(string $source, string $target, string $amount): MoneyTransferred
    {
        return new MoneyTransferred(new CustomerId($source), new CustomerId($target), Money::fromDecimal($amount));
    }

    public static function offer1Applied(string $customerId): Offer1Applied
    {
        return new Offer1Applied(new CustomerId($customerId), Offer::offer1());
    }

    public static function offer2FirstApplied(string $customerId): Offer2Applied
    {
        return new Offer2Applied(new CustomerId($customerId), Offer::offer2FirstPlace());
    }

    public static function offer2SecondApplied(string $customerId): Offer2Applied
    {
        return new Offer2Applied(new CustomerId($customerId), Offer::offer2SecondPlace());
    }

    public static function offer2ThirdApplied(string $customerId): Offer2Applied
    {
        return new Offer2Applied(new CustomerId($customerId), Offer::offer2ThirdPlace());
    }
}
