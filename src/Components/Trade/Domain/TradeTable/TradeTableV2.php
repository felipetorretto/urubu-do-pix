<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable;

class TradeTableV2 implements TradeTable
{
    public function getTable(): array
    {
        return [
            100 => 60,
            200 => 30,
            250 => 25,
            300 => 20,
            350 => 15,
            450 => 10,
        ];
    }

    /**
     * @throws InvalidValueException
     */
    public function calculateGain(float $depositValue): float
    {
        $table = $this->getTable();

        if (! isset($table[$depositValue])) {
            throw new InvalidValueException();
        }

        return 2000;
    }
}
