<?php

namespace App\Modules\Mission\Domain\Exception;

use Throwable;

class InterimaireDejaDansLaMission extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null){
        parent::__construct($message, $code, $previous);
    }
}