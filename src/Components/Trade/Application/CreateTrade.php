<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Application;

use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\Trade;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\TradeRequest;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\TradeRepository;

class CreateTrade
{
    private $repository;

    public function __construct(TradeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(TradeRequest $tradeRequest): Trade
    {
        $mustPayCustomer = false;
        $gain = false;

        $totalDeposits = $this->repository->getTotalDepositsToday();
        if ($totalDeposits > 0) {
            $tradeTable = $tradeRequest->tradeTable();
            $gain = $tradeTable->calculateGain($tradeRequest->valueIn());
            $triggerToPay = $totalDeposits * 0.01;
            $mustPayCustomer = $gain <= $triggerToPay;
        }

        // if the deposit value is lower than the 1% of deposits, pay the customer
        if ($mustPayCustomer) {
            $tradeRequest->setValueOut($gain);
        }

        return $this->repository->create($tradeRequest);
    }
}
