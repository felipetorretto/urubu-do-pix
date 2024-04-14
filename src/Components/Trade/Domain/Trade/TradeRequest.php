<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade;

use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\TradeTable;

class TradeRequest
{
    private $tradeTable;
    private $valueIn;
    private $valueOut = 0;

    public function __construct(TradeTable $tradeTable, float $value)
    {
        $this->tradeTable = $tradeTable;
        $this->valueIn = $value;
    }

    public function setValueOut(float $valueOut): void
    {
        $this->valueOut = $valueOut;
    }

    public function tradeTable(): TradeTable
    {
        return $this->tradeTable;
    }

    public function valueIn(): int
    {
        return $this->valueIn;
    }

    public function valueOut(): int
    {
        return $this->valueOut;
    }
}
