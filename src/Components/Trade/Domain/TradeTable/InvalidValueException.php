<?php

namespace FelipeTorretto\UrubuDoPix\Components\Trade\Domain\TradeTable;

class InvalidValueException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Invalid value');
    }
}
