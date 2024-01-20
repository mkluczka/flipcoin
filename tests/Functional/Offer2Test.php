<?php

declare(strict_types=1);

namespace Tests\Functional;

use Tests\Utils\ItemGenerator\EventGenerator as Events;

final class Offer2Test extends AppTest
{
    /**
     * @dataProvider provideAppCases
     */
    public function testApp(string $commands, array $expectedEvents, array $accountsBalances): void
    {
        $this->runAppTest($commands, $expectedEvents, $accountsBalances);
    }

    private function provideAppCases(): iterable
    {
        yield 'empty' => [
            <<<CASE
            Offer2
            CASE,
            [],
            [],
        ];

        yield 'one customer' => [
            <<<CASE
            CreateWallet Harry 100
            Offer2
            CASE,
            [
                Events::walletCreated('Harry', '100'),
                Events::offerAppliedForOffer2First('Harry'),
            ],
            [
                ['Harry', '110'],
            ],
        ];

        yield '3 customer, no operations, same balance' => [
            <<<CASE
            CreateWallet Harry 100
            CreateWallet Hermione 100
            CreateWallet Ron 100
            Offer2
            CASE,
            [
                Events::walletCreated('Harry', '100'),
                Events::walletCreated('Hermione', '100'),
                Events::walletCreated('Ron', '100'),
                Events::offerAppliedForOffer2First('Harry'),
                Events::offerAppliedForOffer2Second('Hermione'),
                Events::offerAppliedForOffer2Third('Ron'),
            ],
            [
                ['Harry', '110'],
                ['Hermione', '105'],
                ['Ron', '102'],
            ],
        ];

        yield '3 customer, no operations, same balance 2' => [
            <<<CASE
            CreateWallet Ron 100
            CreateWallet Hermione 100
            CreateWallet Harry 100
            Offer2
            CASE,
            [
                Events::walletCreated('Ron', '100'),
                Events::walletCreated('Hermione', '100'),
                Events::walletCreated('Harry', '100'),
                Events::offerAppliedForOffer2First('Ron'),
                Events::offerAppliedForOffer2Second('Hermione'),
                Events::offerAppliedForOffer2Third('Harry'),
            ],
            [
                ['Ron', '110'],
                ['Hermione', '105'],
                ['Harry', '102'],
            ],
        ];
    }
}
