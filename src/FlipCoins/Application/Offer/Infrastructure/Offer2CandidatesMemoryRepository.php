<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Infrastructure;

use MKluczka\FlipCoins\Application\Customer\Domain\Customer\CustomerId;
use MKluczka\FlipCoins\Application\Offer\Domain\Offer2\Candidate\Offer2Candidate;
use MKluczka\FlipCoins\Application\Offer\Domain\Offer2\Candidate\Offer2CandidatesRepository;

class Offer2CandidatesMemoryRepository implements Offer2CandidatesRepository
{
    /**
     * @var array<Offer2Candidate>
     */
    private array $candidates = [];

    #[\Override] public function getCandidates(): array
    {
        return $this->candidates;
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
