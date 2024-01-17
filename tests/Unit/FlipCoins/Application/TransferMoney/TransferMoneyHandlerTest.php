<?php

declare(strict_types=1);

namespace Unit\FlipCoins\Application\TransferMoney;

use MKluczka\FlipCoins\Application\TransferMoney\TransferMoney;
use MKluczka\FlipCoins\Application\TransferMoney\TransferMoneyHandler;
use MKluczka\FlipCoins\Domain\Customer\Customer;
use MKluczka\FlipCoins\Domain\Money\Money;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\MoneyTransferred;
use MKluczka\FlipCoins\Domain\MoneyTransfer\Event\Offer1Applied;
use MKluczka\FlipCoins\Domain\Wallet\Wallet;
use MKluczka\FlipCoins\Domain\Wallet\WalletRepository;
use MKluczka\FlipCoins\Shared\DomainEventDispatcher;
use MKluczka\FlipCoins\Shared\Events;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

final class TransferMoneyHandlerTest extends TestCase
{
    private TransferMoneyHandler $sut;

    private WalletRepository|MockObject $walletRepository;
    private DomainEventDispatcher|MockObject $eventDispatcher;

    protected function setUp(): void
    {
        parent::setUp();

        $this->sut = new TransferMoneyHandler(
            $this->walletRepository = $this->createMock(WalletRepository::class),
            $this->eventDispatcher = $this->createMock(DomainEventDispatcher::class),
        );
    }

    public function testMoneyTransfer(): void
    {
        $sourceCustomer = new Customer('source');
        $targetCustomer = new Customer('target');
        $transferAmount = Money::fromDecimal("12.34");

        $sourceWallet = new Wallet($sourceCustomer, Money::fromDecimal('12.34'));
        $targetWallet = new Wallet($targetCustomer, Money::zero());

        $this->walletRepository
            ->expects($this->exactly(2))
            ->method('getForCustomer')
            ->willReturnOnConsecutiveCalls($sourceWallet, $targetWallet);

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(new Events(new MoneyTransferred($sourceCustomer, $targetCustomer, $transferAmount)));

        $this->sut->__invoke(
            new TransferMoney(
                $sourceCustomer,
                $targetCustomer,
                $transferAmount
            )
        );
    }

    public function testMoneyTransferWithOffer1(): void
    {
        $sourceCustomer = new Customer('source');
        $targetCustomer = new Customer('target');
        $transferAmount = Money::fromDecimal("2");

        $sourceWallet = new Wallet($sourceCustomer, Money::fromDecimal('12'));
        $targetWallet = new Wallet($targetCustomer, Money::fromDecimal('8'));

        $this->walletRepository
            ->expects($this->exactly(2))
            ->method('getForCustomer')
            ->willReturnOnConsecutiveCalls($sourceWallet, $targetWallet);

        $this->eventDispatcher
            ->expects($this->once())
            ->method('dispatch')
            ->with(
                new Events(
                    new MoneyTransferred($sourceCustomer, $targetCustomer, $transferAmount),
                    new Offer1Applied($sourceCustomer),
                    new Offer1Applied($targetCustomer),
                ),
            );

        $this->sut->__invoke(
            new TransferMoney(
                $sourceCustomer,
                $targetCustomer,
                $transferAmount
            )
        );
    }
}
