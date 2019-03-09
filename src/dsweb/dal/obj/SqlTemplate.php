<?php
namespace dsweb\dal\obj;

use Exception;
use RuntimeException;
use dsweb\plog\LoggerFactory;
use dsweb\dal\ConnectionManager;

class SqlTemplate
{

    private $logger;

    private $connectionManager;

    public function __construct(ConnectionManager $connectionManager)
    {
        $this->logger = LoggerFactory::getLogger(__CLASS__);
        $this->connectionManager = $connectionManager;
    }

    public function querySingleValue($sqlStatement)
    {
        $result = $this->queryRawResultList($sqlStatement);
        if ($result != null && count($result) > 0) {
            $keyList = array_keys($result[0]);
            if ($keyList != null && count($keyList) > 0) {
                return $result[0][$keyList[0]];
            }
        }
        return null;
    }

    public function querySingleResult($sqlStatement, $rowMapper)
    {
        $list = $this->query($sqlStatement, $rowMapper);
        if (count($list) > 0) {
            return $list[0];
        }
        return null;
    }

    public function queryRawResultList($sqlStatement)
    {
        $connection = null;
        try {
            $connection = $this->connectionManager->getConnection();
            $this->logger->trace($sqlStatement);
            $resultSet = $connection->execute($sqlStatement);
            $array = array();
            foreach ($resultSet as $row) {
                $array[] = $row->getAsMap();
            }
            return $array;
        } catch (Exception $e) {
            throw new RuntimeException("SqlTemplate::query error", 0, $e);
        } finally {
            if ($connection != null) {
                $this->connectionManager->releaseConnection($connection);
            }
        }
    }

    public function query($sqlStatement, $rowMapper)
    {
        $connection = null;
        try {
            $connection = $this->connectionManager->getConnection();
            $this->logger->trace($sqlStatement);
            $resultSet = $connection->execute($sqlStatement);
            $array = array();
            foreach ($resultSet as $row) {
                $array[] = call_user_func($rowMapper, $row);
            }
            return $array;
        } catch (Exception $e) {
            throw new RuntimeException("SqlTemplate::query error", 0, $e);
        } finally {
            if ($connection != null) {
                $this->connectionManager->releaseConnection($connection);
            }
        }
    }

    public function upsert($sqlStatement)
    {
        $connection = null;
        try {
            $connection = $this->connectionManager->getConnection();
            $this->logger->trace($sqlStatement);
            return $connection->upsert($sqlStatement);
        } catch (Exception $e) {
            throw new RuntimeException("SqlTemplate::upsert error", 0, $e);
        } finally {
            if ($connection != null) {
                $this->connectionManager->releaseConnection($connection);
            }
        }
    }

    public function upsertWithResult($sqlStatement, $callback)
    {
        $connection = null;
        try {
            $connection = $this->connectionManager->getConnection();
            $this->logger->trace($sqlStatement);
            $connection->upsert($sqlStatement);
            return call_user_func($callback, $this);
        } catch (Exception $e) {
            throw new RuntimeException("SqlTemplate::upsertWithResult error", 0, $e);
        } finally {
            if ($connection != null) {
                $this->connectionManager->releaseConnection($connection);
            }
        }
    }
}

?>