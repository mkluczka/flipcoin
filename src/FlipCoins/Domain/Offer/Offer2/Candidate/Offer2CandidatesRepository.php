<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate;

use MKluczka\FlipCoins\Domain\Customer\CustomerId;

interface Offer2CandidatesRepository
{
    public function getCandidates(): Offer2Candidates;

    public function getCandidate(CustomerId $customerId): Offer2Candidate;

    public function newCandidate(CustomerId $customerId): Offer2Candidate;
}
