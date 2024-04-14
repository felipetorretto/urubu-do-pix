<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable;

class TradeTableFactory
{
    public static function factory(string $tradeTableName, array $container = []): TradeTable
    {
        $tradeTable = "FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\\$tradeTableName";

        if (isset($container[$tradeTableName])) {
            return $container[$tradeTableName]();
        }

        return new $tradeTable();
    }
}
