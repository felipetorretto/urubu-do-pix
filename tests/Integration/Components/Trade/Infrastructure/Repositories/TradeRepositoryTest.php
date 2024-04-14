<?php

namespace FelipeTorretto\UrubuDoPix\Integration\Components\Trade\Infrastructure\Repositories;

use DateTime;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\TradeRequest;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\TradeTableV1;
use FelipeTorretto\UrubuDoPix\Components\Trade\Infrastructure\Repositories\TradeRepository;
use FelipeTorretto\UrubuDoPix\Integration\IntegrationTest;
use FelipeTorretto\UrubuDoPix\Models\Trade;

class TradeRepositoryTest extends IntegrationTest
{
    public function testCreate()
    {
        // arrange
        $value = 100;
        $tradeTable = new TradeTableV1();
        $tradeRequest = new TradeRequest($tradeTable, $value);
        $sut = new TradeRepository();

        // act
        $trade = $sut->create($tradeRequest);

        // assert entity data
        $this->assertEquals($tradeTable, $trade->tradeTable());
        $this->assertNotEmpty($trade->id());
        $this->assertEquals($value, $trade->valueIn());
        $this->assertEquals(0, $trade->valueOut());
        $this->assertInstanceOf(DateTime::class, $trade->createdAt());

        // assert database data
        /** @var Trade $tradeModel */
        $tradeModel = Trade::query()->find($trade->id());
        $this->assertEquals($trade->id(), $tradeModel->id);
        $this->assertEquals($trade->valueIn(), $tradeModel->value_in);
        $this->assertEquals($trade->valueOut(), $tradeModel->value_out);
        $this->assertEquals($trade->createdAt(), $tradeModel->created_at);
        $this->assertNotEmpty($tradeModel->updated_at);
    }
}
