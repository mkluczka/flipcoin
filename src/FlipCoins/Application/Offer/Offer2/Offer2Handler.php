<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Offer2;

use MKluczka\FlipCoins\Domain\Customer\CustomerRepository;
use MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate\Offer2CandidatesRepository;
use MKluczka\FlipCoins\Domain\Offer\Offer2\Ranking\Offer2RankingService;
use MKluczka\FlipCoins\Domain\Offer\OfferAwardFactory;
use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class Offer2Handler
{
    public function __construct(
        private Offer2CandidatesRepository $repository,
        private CustomerRepository $customerRepository,
        private Offer2RankingService $rankingService,
        private OfferAwardFactory $awardFactory,
        private DomainEventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(Offer2 $command): void
    {
        $ranking = $this->rankingService->getCustomersRanking($this->repository->getCandidates());

        foreach ($ranking->all() as $place => $awardedCustomer) {
            $award = $this->awardFactory->offer2($place);

            $this->customerRepository
                ->getCustomer($awardedCustomer->customerId)
                ->addOfferAward($award);
        }

        $this->eventDispatcher->dispatchRecordedEvents();
    }
}
