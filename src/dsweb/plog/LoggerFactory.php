<?php
namespace dsweb\plog;

class LoggerFactory
{

    private static $factory;

    public static final function setFactory($factory)
    {
        self::$factory = $factory;
    }

    public static final function getLogger($className)
    {
        return call_user_func(self::$factory, $className);
    }
}

?>