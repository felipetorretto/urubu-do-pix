<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable;

use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Exchange\DollarRepository;

class TradeTableV3 implements TradeTable
{
    private $dollarRepository;

    public function __construct(DollarRepository $dollarRepository)
    {
        $this->dollarRepository = $dollarRepository;
    }

    public function getTable(): array
    {
        return [
            100 => 250,
            150 => 300,
            200 => 550,
            350 => 700,
            400 => 950,
            550 => 1100,
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

        $gainInDollar = $table[$depositValue];

        return $gainInDollar * $this->dollarRepository->getExchangeRate();
    }
}
