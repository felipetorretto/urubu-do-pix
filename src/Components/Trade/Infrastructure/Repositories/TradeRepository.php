<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Infrastructure\Repositories;

use DateTime;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\Trade;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\TradeRepository as TradeRepositoryInterface;
use FelipeTorretto\UrubuDoPix\Components\Trade\Domain\Trade\TradeRequest;
use FelipeTorretto\UrubuDoPix\Models\Trade as TradeModel;

class TradeRepository implements TradeRepositoryInterface
{
    public function create(TradeRequest $tradeRequest): Trade
    {
        $tradeModel = new TradeModel();
        $tradeModel->value_in = $tradeRequest->valueIn();
        $tradeModel->value_out = $tradeRequest->valueOut();
        $tradeModel->created_at = new DateTime();
        $tradeModel->save();

        return new Trade(
            $tradeRequest->tradeTable(),
            $tradeModel->id,
            $tradeModel->value_in,
            $tradeModel->value_out,
            $tradeModel->created_at
        );
    }

    public function getTotalDepositsToday(): float
    {
        $startOfDay = date('Y-m-d 00:00:00');
        $endOfDay = date('Y-m-d 23:59:59');

        $totalIn = TradeModel::query()
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->sum('value_in');

        $totalOut = TradeModel::query()
            ->whereBetween('created_at', [$startOfDay, $endOfDay])
            ->sum('value_out');

        return $totalIn - $totalOut;
    }
}
