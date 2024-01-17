<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\ReadModel\Statement\EventSubscriber;

use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\Offer1Applied;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\ReadModel\Statement\StatementReadModel;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class StatementReadModelSubscriber implements EventSubscriberInterface
{
    public function __construct(private StatementReadModel $readModel)
    {
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
        $this->readModel->addCustomerStatement(
            $event->walletOwner,
            "Money credit: $event->initialAmount, with new wallet",
        );
    }

    public function onMoneyTransferred(MoneyTransferred $event): void
    {
        $this->readModel->addCustomerStatement(
            $event->sourceCustomer,
            "Money debit: $event->amount, to $event->targetCustomer",
        );
        $this->readModel->addCustomerStatement(
            $event->targetCustomer,
            "Money credit: $event->amount, from $event->sourceCustomer",
        );
    }

    public function onOffer1Applied(Offer1Applied $event): void
    {
        $this->readModel->addCustomerStatement(
            $event->customer,
            "Money credit: $event->offerAmount, from Offer 1"
        );
    }
}
