<?php

declare(strict_types=1);

namespace Tests\Functional;

use MKluczka\FlipCoins\ReadModel\Overview\OverviewReadModel;
use MKluczka\FlipCoins\Shared\EventStream;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * @coversNothing
 */
abstract class AppTest extends KernelTestCase
{
    private Application $application;

    protected function setUp(): void
    {
        parent::setUp();

        self::bootKernel();
        $this->application = new Application(self::$kernel);
    }

    protected function runAppTest(string $commands, array $expectedEvents, array $accountBalances): void
    {
        $sut = $this->application->find('flipcoin:app');

        (new CommandTester($sut))->execute(['commands' => $commands]);

        self::assertEquals($expectedEvents, $this->getEvents());
        self::assertAccountBalance($accountBalances);
    }

    private function getEvents(): array
    {
        $eventStream = self::getContainer()->get(EventStream::class);

        return $eventStream->getEvents();
    }

    protected static function assertAccountBalance(array $expectedBalance): void
    {
        $readModel = self::getContainer()->get(OverviewReadModel::class);

        self::assertEquals($expectedBalance, $readModel->getAll());
    }
}
