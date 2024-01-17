<?php

declare(strict_types=1);

namespace Unit\FlipCoins\Domain\Money;

use MKluczka\FlipCoins\Domain\Money\Exception\InvalidMoneyFormat;
use MKluczka\FlipCoins\Domain\Money\Exception\MoneyAmountCannotBeNagative;
use MKluczka\FlipCoins\Domain\Money\Money;
use PHPUnit\Framework\TestCase;

/**
 * @covers \MKluczka\FlipCoins\Domain\Money\Money
 * @covers \MKluczka\FlipCoins\Domain\Money\Exception\InvalidMoneyFormat
 */
final class MoneyTest extends TestCase
{
    /**
     * @dataProvider providInvalidMoneyFormat
     */
    public function testInvalidMoneyFormat(string $decimalAmount): void
    {
        $this->expectException(InvalidMoneyFormat::class);

        Money::fromDecimal($decimalAmount);
    }

    /**
     * @return iterable<int, array<int, string>>
     */
    public static function providInvalidMoneyFormat(): iterable
    {
        yield ['12a'];
        yield ['abc'];
        yield ['-12'];
        yield ['-12.34'];
        yield ['.;[]'];
        yield ['123.12345'];
    }

    /**
     * @dataProvider provideAmountFromDecimal
     */
    public function testAmountFromDecimal(string $decimalAmount, int $expectedAmount): void
    {
        $sut = Money::fromDecimal($decimalAmount);

        self::assertSame($expectedAmount, $sut->amount);
    }

    /**
     * @return iterable<int, array<int, string>>
     */
    public static function provideAmountFromDecimal(): iterable
    {
        yield ['12.34', 123400];
        yield ['32.21', 322100];
        yield ['0', 0];
        yield ['0.0001', 1];
        yield ['0.0010', 10];
        yield ['0.0100', 100];
        yield ['0.1', 1000];
        yield ['0.10', 1000];
        yield ['0.100', 1000];
        yield ['0.1000', 1000];
        yield ['1', 10000];
    }

    /**
     * @dataProvider provideAdd
     */
    public function testAdd(string $left, string $right, string $expectedAmount): void
    {
        $result = Money::fromDecimal($left)->add(Money::fromDecimal($right));

        self::assertEquals($expectedAmount, (string) $result);
        self::assertTrue(Money::fromDecimal($expectedAmount)->equals($result));
    }

    /**
     * @return iterable<int, array<int, string>>
     */
    public static function provideAdd(): iterable
    {
        yield ['0', '5', '5'];
        yield ['12.13', '14.15', '26.28'];
        yield ['555.555', '111.111', '666.666'];
        yield ['11.4321', '22.4321', '33.8642'];
    }

    /**
     * @dataProvider provideAdd
     */
    public function testSubtract(string $expectedAmount, string $right, string $left): void
    {
        $result = Money::fromDecimal($left)->subtract(Money::fromDecimal($right));

        self::assertEquals($expectedAmount, (string) $result);
        self::assertTrue(Money::fromDecimal($expectedAmount)->equals($result));
    }

    public function testSubtractToNegativeFails(): void
    {
        $this->expectException(MoneyAmountCannotBeNagative::class);

        Money::zero()->subtract(Money::fromDecimal('1'));
    }
}
