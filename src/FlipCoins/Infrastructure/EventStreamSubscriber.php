<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Infrastructure;

use MKluczka\FlipCoins\Domain\Customer\Event\Offer2Applied;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\Offer\Event\OfferApplied;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Shared\EventStream;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class EventStreamSubscriber implements EventSubscriberInterface
{
    public function __construct(private EventStream $eventStream)
    {
    }

    #[\Override] public static function getSubscribedEvents(): array
    {
        return [
            WalletCreated::class => 'onEvent',
            MoneyTransferred::class => 'onEvent',
            OfferApplied::class => 'onEvent',
            Offer2Applied::class => 'onEvent',
        ];
    }

    public function onEvent(object $event): void
    {
        $this->eventStream->addEvent($event);
    }
}
