<?php
namespace dsweb\dal\exception;

use RuntimeException;
use Exception;

class TransactionConcurrencyException extends RuntimeException implements DalConcurrencyException
{

    public function __construct($message = null, $code = 0, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}

?>