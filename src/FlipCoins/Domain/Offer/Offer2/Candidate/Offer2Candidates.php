<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate;

use MKluczka\FlipCoins\Domain\Customer\Event\Offer2Applied;
use MKluczka\FlipCoins\Domain\Offer\Offer2\Ranking\Offer2RankingService;
use MKluczka\FlipCoins\Domain\Offer\OfferFactory;
use MKluczka\FlipCoins\Shared\Events;

final readonly class Offer2Candidates
{
    /** @var array<string>  */
    private const array RANKING_AWARDS = ['10', '5', '2'];

    public function __construct(
        private array $candidates,
        private Offer2RankingService $rankingService,
        private OfferFactory $offerFactory,
        private Events $events,
    ) {
    }

    public function applyOffer(): void
    {
        $ranking = $this->rankingService->getCustomersRanking($this->candidates);

        foreach ($ranking->all() as $place => $awardedCustomer) {
            $this->events->record(
                new Offer2Applied(
                    $awardedCustomer->customerId,
                    $this->offerFactory->offer2(self::RANKING_AWARDS[$place])
                )
            );
        }
    }
}
