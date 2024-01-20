<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\ReadModel\Statement\EventSubscriber;

use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\Offer\Event\OfferAwardApplied;
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
            OfferAwardApplied::class => 'onOfferApplied',
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
            "Money debit: $event->transactionAmount, to $event->targetCustomer",
        );
        $this->readModel->addCustomerStatement(
            $event->targetCustomer,
            "Money credit: $event->transactionAmount, from $event->sourceCustomer",
        );
    }

    public function onOfferApplied(OfferAwardApplied $event): void
    {
        $this->readModel->addCustomerStatement(
            $event->customerId,
            "Money credit: $event->award"
        );
    }
}
