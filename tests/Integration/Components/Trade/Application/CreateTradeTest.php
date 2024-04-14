<?php

namespace FelipeTorretto\UrubuDoPix\Integration\Components\Trade\Application;

use DateTime;
use FelipeTorretto\UrubuDoPix\Components\Trade\Application\CreateTrade;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Exchange\DollarRepository;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\TradeRequest;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\TradeTableFactory;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\TradeTableV3;
use FelipeTorretto\UrubuDoPix\Components\Trade\Infrastructure\Repositories\TradeRepository;
use FelipeTorretto\UrubuDoPix\Integration\IntegrationTest;
use FelipeTorretto\UrubuDoPix\Models\Trade;
use Mockery;

class CreateTradeTest extends IntegrationTest
{
    /**
     * @dataProvider dataProvider
     */
    public function testDontPayTheCustomerWhenThePlatformDontReceivedEnoughMoney(string $tradeTable, array $container)
    {
        // arrange
        $tradeTable = TradeTableFactory::factory($tradeTable, $container);
        $tradeRequest = new TradeRequest($tradeTable, 200);
        $tradeRepository = new TradeRepository();
        $sut = new CreateTrade($tradeRepository);

        // act
        $trade = $sut($tradeRequest);

        // assert
        $this->assertEquals(0, $trade->valueOut());
    }

    public function dataProvider(): array
    {
        $container['TradeTableV3'] = function () {
            $mock = Mockery::mock(DollarRepository::class)
                ->shouldReceive('getExchangeRate')
                ->andReturn(5.07)
                ->getMock();

            return new TradeTableV3($mock);
        };

        return [
            ['TradeTableV1', []],
            ['TradeTableV2', []],
            ['TradeTableV3', $container],
        ];
    }

    public function testDontPayTheCustomerWhenThePlatformDoesNotAlreadyReceivedEnoughMoney()
    {
        // arrange
        $tradeTable = TradeTableFactory::factory('TradeTableV1');
        $tradeRequest = new TradeRequest($tradeTable, 200);
        $tradeRepository = new TradeRepository();
        $sut = new CreateTrade($tradeRepository);

        // create a trade with the value to activate the gain on the next trade
        $yesterday = new DateTime('yesterday');
        $this->createTradeOnDatabase(200000, $yesterday);

        // act
        $trade = $sut($tradeRequest);

        // assert
        $this->assertEquals(0, $trade->valueOut());
    }

    public function testPayTheCustomerWhenThePlatformAlreadyReceivedEnoughMoney()
    {
        // arrange
        $tradeTable = TradeTableFactory::factory('TradeTableV1');
        $tradeRequest = new TradeRequest($tradeTable, 200);
        $tradeRepository = new TradeRepository();
        $sut = new CreateTrade($tradeRepository);

        // create a trade with the value to activate the gain on the next trade
        $today = new DateTime();
        $this->createTradeOnDatabase(200000, $today);

        // act
        $trade = $sut($tradeRequest);

        // assert
        $this->assertEquals(2000, $trade->valueOut());
    }

    private function createTradeOnDatabase(float $value, DateTime $createdAt): void
    {
        $trade = new Trade();
        $trade->value_in = $value;
        $trade->created_at = $createdAt;
        $trade->save();
    }
}
