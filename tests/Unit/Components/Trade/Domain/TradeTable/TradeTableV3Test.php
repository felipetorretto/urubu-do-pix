<?php

namespace FelipeTorretto\UrubuDoPix\Unit\Components\Trade\Domain\TradeTable;

use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Exchange\DollarRepository;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\InvalidValueException;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\TradeTableV3;
use Mockery;
use PHPUnit\Framework\TestCase;

class TradeTableV3Test extends TestCase
{
    /**
     * @dataProvider gainDataProvider
     */
    public function testGain(float $depositValue, float $expectedReturn)
    {
        // arrange
        $mock = Mockery::mock(DollarRepository::class)
            ->shouldReceive('getExchangeRate')
            ->andReturn(5.07)
            ->getMock();

        // act
        $return = (new TradeTableV3($mock))->calculateGain($depositValue);

        // assert
        $this->assertEquals($expectedReturn, $return);
    }

    public function gainDataProvider(): array
    {
        return [
            [100, 1267.5],
            [150, 1521],
            [200, 2788.5],
            [350, 3549],
            [400, 4816.5],
            [550, 5577],
        ];
    }

    public function testThrowAnExceptionIfTheValueIsNotOnTradeTable()
    {
        $this->expectException(InvalidValueException::class);

        // arrange
        $mock = Mockery::mock(DollarRepository::class)
            ->shouldReceive('getExchangeRate')
            ->andReturn(5.07)
            ->getMock();

        // act
        $invalidValue = 50;
        $return = (new TradeTableV3($mock))->calculateGain($invalidValue);
    }
}
