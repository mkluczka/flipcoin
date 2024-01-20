<?php

declare(strict_types=1);

namespace MKluczka\FlipCoins\Application\Offer\Offer2;

use MKluczka\FlipCoins\Domain\Offer\Offer2\Candidate\Offer2CandidatesRepository;
use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
final readonly class Offer2Handler
{
    public function __construct(
        private Offer2CandidatesRepository $repository,
        private DomainEventDispatcher $eventDispatcher,
    ) {
    }

    public function __invoke(Offer2 $command): void
    {
        $this->repository
            ->getCandidates()
            ->applyOffer();

        $this->eventDispatcher->dispatchRecordedEvents();
    }
}
