<?php

namespace FelipeTorretto\UrubuDoPix\Unit\Components\Trade\Domain\TradeTable;

use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\InvalidValueException;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\TradeTableV1;
use PHPUnit\Framework\TestCase;

class TradeTableV1Test extends TestCase
{
    /**
     * @dataProvider gainDataProvider
     */
    public function testGain(float $depositValue, float $expectedReturn)
    {
        // act
        $return = (new TradeTableV1)->calculateGain($depositValue);

        // assert
        $this->assertEquals($expectedReturn, $return);
    }

    public function testThrowAnExceptionIfTheValueIsNotOnTradeTable()
    {
        $this->expectException(InvalidValueException::class);

        // act
        $invalidValue = 50;
        $return = (new TradeTableV1)->calculateGain($invalidValue);
    }

    public function gainDataProvider(): array
    {
        return [
            [200, 2000],
            [250, 2500],
            [300, 3000],
            [400, 4000],
            [500, 5000],
        ];
    }
}
