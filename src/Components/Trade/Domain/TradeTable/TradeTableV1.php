<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable;

class TradeTableV1 implements TradeTable
{
    public function getTable(): array
    {
        return [
            200 => 2000,
            250 => 2500,
            300 => 3000,
            400 => 4000,
            500 => 5000,
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

        return $table[$depositValue];
    }
}
