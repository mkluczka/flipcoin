<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Shared\Infrastructure;

use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Application\Customer\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Application\Offer\Domain\Event\OfferAwardApplied;
use MKluczka\FlipCoins\Shared\Domain\EventStream;
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
            OfferAwardApplied::class => 'onEvent',
        ];
    }

    public function onEvent(object $event): void
    {
        $this->eventStream->addEvent($event);
    }
}
