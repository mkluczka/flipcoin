<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Application\Offer2;

use MKluczka\FlipCoins\Application\Offer\Application\OfferAwardsService;
use MKluczka\FlipCoins\Application\Offer\Domain\Offer2\Candidate\Offer2CandidatesRepository;
use MKluczka\FlipCoins\Application\Offer\Domain\Offer2\Ranking\Offer2RankingService;
use MKluczka\FlipCoins\Application\Offer\Domain\OfferAwardFactory;
use MKluczka\FlipCoins\Shared\Domain\DomainEventDispatcher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class Offer2Handler
{
    public function __construct(
        private Offer2CandidatesRepository $repository,
        private Offer2RankingService $rankingService,
        private OfferAwardFactory $awardFactory,
        private OfferAwardsService $offerAwardsService,
        private DomainEventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(Offer2 $command): void
    {
        $ranking = $this->rankingService->getCustomersRanking($this->repository->getCandidates());

        foreach ($ranking->all() as $place => $awardedCustomer) {
            $award = $this->awardFactory->offer2($place);

            $this->offerAwardsService->grantAward($awardedCustomer->customerId, $award);
        }

        $this->eventDispatcher->dispatchRecordedEvents();
    }
}
