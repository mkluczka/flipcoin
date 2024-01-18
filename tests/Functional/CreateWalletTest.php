<?php

declare(strict_types=1);

namespace Tests\Functional;

use Tests\Utils\ItemGenerator\EventGenerator as Events;

final class CreateWalletTest extends AppTest
{
    /**
     * @dataProvider provideAppCases
     */
    public function testApp(string $commands, array $expectedEvents, array $accountBalances): void
    {
        $this->runAppTest($commands, $expectedEvents, $accountBalances);
    }

    private function provideAppCases(): iterable
    {
        yield ['', [], []];

        yield [
            'CreateWallet Harry 0',
            [Events::walletCreated('Harry', '0')],
            [['Harry', '0']],
        ];

        yield [
            'CreateWallet Harry 100',
            [Events::walletCreated('Harry', '100')],
            [['Harry', '100']],
        ];

        yield [
            'CreateWallet Harriet 999',
            [Events::walletCreated('Harriet', '999')],
            [['Harriet', '999']],
        ];
    }
}
