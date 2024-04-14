<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Exchange;

interface DollarRepository
{
    public function getExchangeRate(): float;
}
