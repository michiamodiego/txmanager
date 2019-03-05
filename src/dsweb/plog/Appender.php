<?php
namespace dsweb\plog;

interface Appender
{

    function append($className, $functionName, $line, $time, $logLevel, $message, $e);
}

?>