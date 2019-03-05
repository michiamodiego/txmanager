<?php
namespace dsweb\plog;

class DefaultFileAppender implements Appender
{

    private $dateFormat;

    private $fileName;

    public function __construct($dateFormat, $fileName)
    {
        $this->dateFormat = $dateFormat;
        $this->fileName = $fileName;
    }

    public function append($className, $functionName, $line, $time, $logLevel, $message, $e = null)
    {
        $newline = "\r\n";
        $fh = fopen($this->fileName, "a+");
        $date = date($this->dateFormat, $time);
        $logLevelName = LogLevel::getLogLevelName($logLevel);
        fwrite($fh, "${date} :: ${className} :: ${functionName} (${line}) :: ${logLevelName} :: ${message}");
        if ($e != null) {
            fwrite($fh, $newline);
            fwrite($fh, "StackTrace: ");
            fwrite($fh, $e);
        }
        fwrite($fh, $newline);
        fclose($fh);
    }
}

?>