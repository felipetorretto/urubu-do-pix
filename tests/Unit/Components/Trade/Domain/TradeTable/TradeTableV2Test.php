<?php

namespace FelipeTorretto\UrubuDoPix\Unit\Components\Trade\Domain\TradeTable;

use DateTime;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\TradeRequest;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\InvalidValueException;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\TradeTableV2;
use PHPUnit\Framework\TestCase;

class TradeTableV2Test extends TestCase
{
    /**
     * @dataProvider gainDataProvider
     */
    public function testGain(float $depositValue, float $expectedReturn)
    {
        // act
        $return = (new TradeTableV2)->calculateGain($depositValue);

        // assert
        $this->assertEquals($expectedReturn, $return);
    }

    public function testThrowAnExceptionIfTheValueIsNotOnTradeTable()
    {
        $this->expectException(InvalidValueException::class);

        // act
        $invalidValue = 50;
        $return = (new TradeTableV2)->calculateGain($invalidValue);
    }

    public function gainDataProvider(): array
    {
        return [
            [100, 2000],
            [200, 2000],
            [250, 2000],
            [300, 2000],
            [350, 2000],
            [450, 2000],
        ];
    }
}
