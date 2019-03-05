<?php
namespace dsweb\plog;

class Logger
{

    private $logLevel;

    private $className;

    private $appenderList;

    public function __construct($logLevel, $className, $appenderList)
    {
        $this->logLevel = $logLevel;
        $this->className = $className;
        $this->appenderList = $appenderList;
    }

    private function getFunctionAndLine()
    {
        $trace = debug_backtrace();
        $level = 3;
        return array(
            "function" => $trace[$level]["function"],
            "line" => isset($trace[$level]["line"]) ? $trace[$level]["line"] : - 1
        );
    }

    private function log($logLevel, $message, $e)
    {
        if ($this->logLevel <= $logLevel) {
            $functionAndLine = $this->getFunctionAndLine();
            for ($i = 0; $i < count($this->appenderList); $i ++) {
                $this->appenderList[$i]->append($this->className, $functionAndLine["function"], $functionAndLine["line"], time(), $logLevel, $message, $e);
            }
        }
    }

    public function trace($message, $e = null)
    {
        $this->log(LogLevel::TRACE, $message, $e);
    }

    public function debug($message, $e = null)
    {
        $this->log(LogLevel::DEBUG, $message, $e);
    }

    public function info($message, $e)
    {
        $this->log(LogLevel::INFO, $message, $e);
    }

    public function error($message, $e)
    {
        $this->log(LogLevel::ERROR, $message, $e);
    }
}

?>