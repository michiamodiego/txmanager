<?php
namespace dsweb\dal\util;

use dsweb\plog\LoggerFactory;
use dsweb\dal\ConnectionFactory;
use dsweb\dal\Connection;

class ConnectionUtils
{

    // mod_php is thread-safe and to be honest I have never seen a multithreaded php application => no thread-locals
    // Since no connection pool is available for php then the idea is to keep one connection open throughout the request
    private static $staticContext = null;

    private static $logger = null;

    private static function staticConstructor()
    {
        if (self::$staticContext == null) {
            self::$logger = LoggerFactory::getLogger(__CLASS__);
            self::$staticContext = array();
        }
    }

    private static $connectionHolder = null;

    public static function getConnection(ConnectionFactory $connectionFactory)
    {
        self::staticConstructor();
        if (self::$connectionHolder != null) {
            self::$connectionHolder->requested();
            self::$logger->trace("The connection has been requested again. No: " . self::$connectionHolder->getCounter());
            return self::$connectionHolder->getConnection();
        }
        self::$connectionHolder = new ConnectionHolder($connectionFactory->getConnection());
        self::$connectionHolder->requested();
        self::$logger->trace("New connection requested. No: " . self::$connectionHolder->getCounter());
        return self::$connectionHolder->getConnection();
    }

    public static function releaseConnection(Connection $connection)
    {
        self::staticConstructor();
        $released = self::$connectionHolder->released();
        self::$logger->trace("The connection has been released. No: " . $released);
        if (self::$connectionHolder != null && $released == 0) {
            self::$connectionHolder->getConnection()->close();
            self::$connectionHolder = null;
        }
    }
}

?>