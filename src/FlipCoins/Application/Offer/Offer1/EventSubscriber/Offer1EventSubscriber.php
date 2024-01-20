<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Offer1\EventSubscriber;

use MKluczka\FlipCoins\Domain\Customer\CustomerRepository;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\Offer1Applied;
use MKluczka\FlipCoins\Domain\Offer\OfferFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

final readonly class Offer1EventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private OfferFactory $offerFactory,
        private CustomerRepository $customerRepository
    ) {
    }

    #[\Override]
    public static function getSubscribedEvents(): array
    {
        return [
            Offer1Applied::class => 'onOffer1Applied',
        ];
    }

    public function onOffer1Applied(Offer1Applied $event): void
    {
        $offer = $this->offerFactory->offer1();

        $this->customerRepository
            ->getCustomer($event->sourceCustomer)
            ->applyOffer($offer);

        $this->customerRepository
            ->getCustomer($event->targetCustomerId)
            ->applyOffer($offer);
    }
}
