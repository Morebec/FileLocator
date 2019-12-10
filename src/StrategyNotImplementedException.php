<?php

namespace Morebec\FileLocator;

use Throwable;

class StrategyNotImplementedException extends \Exception
{
    public function __construct(FileLocatorStrategy $strategy, $code = 0, Throwable $previous = null)
    {
        parent::__construct("Strategy '$strategy' not implemented", $code, $previous);
    }
}
