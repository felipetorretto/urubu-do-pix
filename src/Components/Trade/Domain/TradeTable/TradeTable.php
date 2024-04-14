<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable;

interface TradeTable
{
    public function getTable(): array;

    public function calculateGain(float $depositValue): float;
}
