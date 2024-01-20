<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Adapters\EventSubscriber;

use MKluczka\FlipCoins\Application\Customer\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Application\Offer\Application\OfferAwardsService;
use MKluczka\FlipCoins\Application\Offer\Domain\OfferAwardFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class Offer1EventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private OfferAwardFactory $offerFactory,
        private OfferAwardsService $offerAwardsService,
    ) {
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            MoneyTransferred::class => 'onMoneyTransferred',
        ];
    }

    public function onMoneyTransferred(MoneyTransferred $event): void
    {
        if ($event->sourceBalanceAfter->equals($event->targetBalanceAfter)) {
            $award = $this->offerFactory->offer1();

            $this->offerAwardsService->grantAward($event->sourceCustomerId, $award);
            $this->offerAwardsService->grantAward($event->targetCustomerId, $award);
        }
    }
}
