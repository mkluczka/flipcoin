<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Infrastructure;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate\Offer2Candidate;
use MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate\Offer2Candidates;
use MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate\Offer2CandidatesRepository;
use MKluczka\FlipCoins\Domain\Offer\Offer2\Ranking\Offer2RankingService;
use MKluczka\FlipCoins\Domain\Offer\OfferFactory;
use MKluczka\FlipCoins\Shared\Events;

class Offer2CandidatesMemoryRepository implements Offer2CandidatesRepository
{
    private array $candidates = [];

    public function __construct(
        private readonly Offer2RankingService $rankingService,
        private readonly OfferFactory $offerFactory,
        private readonly Events $events,
    ) {
    }

    #[\Override] public function getCandidates(): Offer2Candidates
    {
        return new Offer2Candidates(
            $this->candidates,
            $this->rankingService,
            $this->offerFactory,
            $this->events,
        );
    }

    #[\Override] public function getCandidate(CustomerId $customerId): Offer2Candidate
    {
        return $this->candidates[(string) $customerId] ?? throw new \RuntimeException('Offer2 candidate not found');
    }

    #[\Override] public function newCandidate(CustomerId $customerId): Offer2Candidate
    {
        $this->candidates[(string) $customerId] = new Offer2Candidate($customerId);

        return $this->getCandidate($customerId);
    }
}
