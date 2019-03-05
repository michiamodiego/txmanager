<?php
namespace dsweb\dal\util;

use Exception;
use RuntimeException;
use dsweb\plog\LoggerFactory;
use dsweb\dal\ConnectionManager;

class TransactionUtils
{

    // mod_php is thread-safe and to be honest I have never saw a multithreaded php application => no thread-locals
    private static $staticContext = null;

    private static $logger = null;

    private static $transaction = null;

    private static function staticConstructor()
    {
        if (self::$staticContext == null) {
            self::$logger = LoggerFactory::getLogger(__CLASS__);
            self::$staticContext = array();
        }
    }

    private static function getOrCreateTransaction(ConnectionManager $connectionManager)
    {
        if (self::$transaction == null) {
            self::$transaction = new Transaction($connectionManager);
        }
        return self::$transaction;
    }

    private static function releaseTransaction()
    {
        self::$transaction->release();
        if (self::$transaction->isCompleted()) {
            self::$transaction = null;
        }
    }

    public static function doInTransaction(ConnectionManager $connectionManager, $callback)
    {
        self::staticConstructor();
        try {
            self::getOrCreateTransaction($connectionManager)->beginTransaction();
            call_user_func($callback);
            self::getOrCreateTransaction($connectionManager)->commit();
        } catch (Exception $e) {
            self::getOrCreateTransaction($connectionManager)->rollback();
            throw new RuntimeException("The transaction has been rolledback", 0, $e);
        } finally {
            self::releaseTransaction();
        }
    }

    public static function doInTransactionWithResult(ConnectionManager $connectionManager, $callback)
    {
        self::staticConstructor();
        $result = null;
        try {
            self::getOrCreateTransaction($connectionManager)->beginTransaction();
            $result = call_user_func($callback);
            self::getOrCreateTransaction($connectionManager)->commit();
            return $result;
        } catch (Exception $e) {
            self::getOrCreateTransaction($connectionManager)->rollback();
            throw new RuntimeException("The transaction has been rolledback", 0, $e);
        } finally {
            self::releaseTransaction();
        }
    }
}

?>