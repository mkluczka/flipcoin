<?php

declare(strict_types=1);

namespace Tests\Utils\ItemGenerator;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Application\Offer\Domain\Event\OfferAwardApplied;
use MKluczka\FlipCoins\Application\Offer\Domain\OfferAward;
use MKluczka\FlipCoins\Shared\Domain\Money\Money;

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

    public static function offerAppliedForOffer2First(string $customerId): OfferAwardApplied
    {
        return new OfferAwardApplied(
            new CustomerId($customerId),
            new OfferAward('Offer2', Money::fromDecimal('10')),
        );
    }

    public static function offerAppliedForOffer2Second(string $customerId): OfferAwardApplied
    {
        return new OfferAwardApplied(
            new CustomerId($customerId),
            new OfferAward('Offer2', Money::fromDecimal('5'))
        );
    }

    public static function offerAppliedForOffer2Third(string $customerId): OfferAwardApplied
    {
        return new OfferAwardApplied(
            new CustomerId($customerId),
            new OfferAward('Offer2', Money::fromDecimal('2'))
        );
    }

    public static function offer1Applied(string $customerId): OfferAwardApplied
    {
        return new OfferAwardApplied(
            new CustomerId($customerId),
            new OfferAward('Offer1', Money::fromDecimal('10'))
        );
    }
}
