<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Offer2\EventSubscriber;

use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate\Offer2CandidatesRepository;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class Offer2EventSubscriber implements EventSubscriberInterface
{
    public function __construct(private Offer2CandidatesRepository $repository)
    {
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            WalletCreated::class => 'onWalletCreated',
            MoneyTransferred::class => 'onMoneyTransferred',
        ];
    }

    public function onWalletCreated(WalletCreated $event): void
    {
        $this->repository
            ->newCandidate($event->walletOwner)
            ->changeBalance($event->initialAmount);
    }

    public function onMoneyTransferred(MoneyTransferred $event): void
    {
        $this->repository
            ->getCandidate($event->sourceCustomer)
            ->addTransferCount()
            ->changeBalance($event->sourceBalanceAfter);
    }
}
