<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade;

interface TradeRepository
{
    public function create(TradeRequest $tradeRequest): Trade;

    public function getTotalDepositsToday(): float;
}
