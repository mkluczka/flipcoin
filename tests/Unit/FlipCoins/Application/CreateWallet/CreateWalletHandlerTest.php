<?php

declare(strict_types=1);

namespace Unit\FlipCoins\Application\CreateWallet;

use MKluczka\FlipCoins\Application\CreateWallet\CreateWallet;
use MKluczka\FlipCoins\Application\CreateWallet\CreateWalletHandler;
use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\Wallet\Event\WalletCreated;
use MKluczka\FlipCoins\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Domain\Wallet\WalletCollection;
use MKluczka\FlipCoins\Domain\Wallet\WalletRepository;
use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use MKluczka\FlipCoins\Shared\Events;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class CreateWalletHandlerTest extends TestCase
{
    private CreateWalletHandler $sut;

    private WalletRepository|MockObject $walletRepository;
    private DomainEventDispatcher|MockObject $eventDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new CreateWalletHandler(
            $this->walletRepository = $this->createMock(WalletRepository::class),
            $this->eventDispatcher = $this->createMock(DomainEventDispatcher::class),
        );
    }

    public function testCreateWallet(): void
    {
        $customer = new Customer('initial');
        $initialAmount = Money::fromDecimal('43.21');
        $walletCollection = new WalletCollection([]);

        $this->walletRepository
            ->expects($this->once())
            ->method('getCollection')
            ->willReturnOnConsecutiveCalls($walletCollection);

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(new Events(new WalletCreated($customer, $initialAmount)));

        $this->sut->__invoke(new CreateWallet($customer, $initialAmount));
    }

    public function testDoNothingOnCreateWithExistingWallet(): void
    {
        $customer = new Customer('initial');
        $initialAmount = Money::fromDecimal('43.21');
        $walletCollection = new WalletCollection(['initial' => new Wallet($customer, Money::zero())]);

        $this->walletRepository
            ->expects($this->once())
            ->method('getCollection')
            ->willReturnOnConsecutiveCalls($walletCollection);

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(new Events());

        $this->sut->__invoke(new CreateWallet($customer, $initialAmount));
    }
}
