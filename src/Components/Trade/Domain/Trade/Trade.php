<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade;

use DateTime;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable\TradeTable;

class Trade
{
    private $tradeTable;
    private $id;
    private $valueIn;
    private $valueOut;
    private $createdAt;

    public function __construct(
        TradeTable $tradeTable,
        int $id,
        float $valueIn,
        float $valueOut,
        DateTime $createdAt
    ) {
        $this->tradeTable = $tradeTable;
        $this->id = $id;
        $this->valueIn = $valueIn;
        $this->valueOut = $valueOut;
        $this->createdAt = $createdAt;
    }

    public function tradeTable(): TradeTable
    {
        return $this->tradeTable;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function valueIn(): float
    {
        return $this->valueIn;
    }

    public function valueOut(): float
    {
        return $this->valueOut;
    }

    public function createdAt(): DateTime
    {
        return $this->createdAt;
    }
}
