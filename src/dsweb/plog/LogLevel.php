<?php
namespace dsweb\plog;

class LogLevel
{

    const ALL = 0;

    const TRACE = 1000;

    const DEBUG = 2000;

    const INFO = 3000;

    const ERROR = 4000;

    const OFF = 5000;

    public static function getLogLevelName($level)
    {
        switch ($level) {
            case self::ALL:
                return "ALL";
            case self::TRACE:
                return "TRACE";
            case self::DEBUG:
                return "DEBUG";
            case self::INFO:
                return "INFO";
            case self::ERROR:
                return "ERROR";
            case self::OFF:
                return "OFF";
        }
    }
}

?>