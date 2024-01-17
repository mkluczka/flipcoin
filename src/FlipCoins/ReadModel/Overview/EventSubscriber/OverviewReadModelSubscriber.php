<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\ReadModel\Overview\EventSubscriber;

use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\Offer1Applied;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\ReadModel\Overview\OverviewReadModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final class OverviewReadModelSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly OverviewReadModel $readModel,
    ) {
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            WalletCreated::class => 'onWalletCreated',
            MoneyTransferred::class => 'onMoneyTransferred',
            Offer1Applied::class => 'onOffer1Applied',
        ];
    }

    public function onWalletCreated(WalletCreated $event): void
    {
        $this->readModel->setForCustomer($event->walletOwner, $event->initialAmount);
    }

    public function onMoneyTransferred(MoneyTransferred $event): void
    {
        $this->readModel->subtract($event->sourceCustomer, $event->amount);
        $this->readModel->add($event->targetCustomer, $event->amount);
    }

    public function onOffer1Applied(Offer1Applied $event): void
    {
        $this->readModel->add($event->customer, $event->offerAmount);
    }
}
