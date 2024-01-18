<?php

declare(strict_types=1);

namespace Tests\Functional;

use Tests\Utils\ItemGenerator\EventGenerator as Events;

final class MoneyTransferTest extends AppTest
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
        yield [
            <<<CASE
            CreateWallet Harry 100
            CreateWallet Hermione 104
            TransferMoney Hermione Harry 3
            CASE,
            [
                Events::walletCreated('Harry', '100'),
                Events::walletCreated('Hermione', '104'),
                Events::moneyTransferred('Hermione', 'Harry', '3'),
            ],
            [
                ['Harry', '103'],
                ['Hermione', '101'],
            ],
        ];

        yield [
            <<<CASE
            CreateWallet Harry 100
            CreateWallet Hermione 104
            TransferMoney Hermione Harry 2
            CASE,
            [
                Events::walletCreated('Harry', '100'),
                Events::walletCreated('Hermione', '104'),
                Events::moneyTransferred('Hermione', 'Harry', '2'),
                Events::offer1Applied('Hermione'),
                Events::offer1Applied('Harry'),
            ],
            [
                ['Harry', '112'],
                ['Hermione', '112'],
            ],
        ];

        yield [
            <<<CASE
            CreateWallet Harry 100
            CreateWallet Hermione 200
            TransferMoney Harry Hermione 100
            CASE,
            [
                Events::walletCreated('Harry', '100'),
                Events::walletCreated('Hermione', '200'),
                Events::moneyTransferred('Harry', 'Hermione', '100'),
            ],
            [
                ['Harry', '0'],
                ['Hermione', '300'],
            ],
        ];
    }
}
