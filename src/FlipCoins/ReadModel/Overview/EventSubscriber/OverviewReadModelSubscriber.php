<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\ReadModel\Overview\EventSubscriber;

use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Application\Offer\Domain\Event\OfferAwardApplied;
use MKluczka\FlipCoins\ReadModel\Overview\OverviewReadModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class OverviewReadModelSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private OverviewReadModel $readModel,
    ) {
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            WalletCreated::class => 'onWalletCreated',
            MoneyTransferred::class => 'onMoneyTransferred',
            OfferAwardApplied::class => 'onOfferApplied',
        ];
    }

    public function onWalletCreated(WalletCreated $event): void
    {
        $this->readModel->setForCustomer($event->walletOwner, $event->initialAmount);
    }

    public function onMoneyTransferred(MoneyTransferred $event): void
    {
        $this->readModel->setForCustomer($event->sourceCustomerId, $event->sourceBalanceAfter);
        $this->readModel->setForCustomer($event->targetCustomerId, $event->targetBalanceAfter);
    }

    public function onOfferApplied(OfferAwardApplied $event): void
    {
        $this->readModel->add($event->customerId, $event->award->amount);
    }
}
