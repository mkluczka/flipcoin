<?php

declare(strict_types=1);

namespace Tests\Utils\ItemGenerator;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Customer\Event\Offer2Applied;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\Offer\Event\OfferApplied;
use MKluczka\FlipCoins\Domain\Offer\Offer;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;

final readonly class EventGenerator
{
    public static function walletCreated(string $customerId, string $amount): WalletCreated
    {
        return new WalletCreated(new CustomerId($customerId), Money::fromDecimal($amount));
    }

    public static function moneyTransferred(
        string $source,
        string $sourceBalance,
        string $target,
        string $targetBalance,
        string $amount
    ): MoneyTransferred {
        return new MoneyTransferred(
            new CustomerId($source),
            Money::fromDecimal($sourceBalance),
            new CustomerId($target),
            Money::fromDecimal($targetBalance),
            Money::fromDecimal($amount)
        );
    }

    public static function offer2FirstApplied(string $customerId): Offer2Applied
    {
        return new Offer2Applied(
            new CustomerId($customerId),
            new Offer('Offer2', Money::fromDecimal('10'))
        );
    }

    public static function offer2SecondApplied(string $customerId): Offer2Applied
    {
        return new Offer2Applied(
            new CustomerId($customerId),
            new Offer('Offer2', Money::fromDecimal('5'))
        );
    }

    public static function offer2ThirdApplied(string $customerId): Offer2Applied
    {
        return new Offer2Applied(
            new CustomerId($customerId),
            new Offer('Offer2', Money::fromDecimal('2'))
        );
    }

    public static function offer1Applied(string $customerId): OfferApplied
    {
        return new OfferApplied(
            new CustomerId($customerId),
            new Offer('Offer1', Money::fromDecimal('10'))
        );
    }
}
