<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\ReadModel\Statement\EventSubscriber;

use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Application\Offer\Domain\Event\OfferAwardApplied;
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
            $event->sourceCustomerId,
            "Money debit: $event->transactionAmount, to $event->targetCustomerId",
        );
        $this->readModel->addCustomerStatement(
            $event->targetCustomerId,
            "Money credit: $event->transactionAmount, from $event->sourceCustomerId",
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
