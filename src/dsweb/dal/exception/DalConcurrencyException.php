<?php
namespace dsweb\dal\exception;

use dsweb\exception\ConcurrencyException;

interface DalConcurrencyException extends DataAccessLayerException, ConcurrencyException
{
}

?>