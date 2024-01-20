<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Adapters\EventSubscriber;

use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Application\Offer\Domain\Offer2\Candidate\Offer2CandidatesRepository;
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
            ->getCandidate($event->sourceCustomerId)
            ->addTransferCount()
            ->changeBalance($event->sourceBalanceAfter);
    }
}
