<?php
namespace dsweb\dal\util;

use RuntimeException;
use dsweb\plog\LoggerFactory;
use dsweb\dal\ConnectionManager;

class Transaction
{

    private $logger;

    private $counter;

    private $connectionManager;

    private $connection;

    private $rolledback;

    private $completed;

    public function __construct(ConnectionManager $connectionManager)
    {
        $this->logger = LoggerFactory::getLogger(__CLASS__);
        $this->counter = 0;
        $this->connectionManager = $connectionManager;
        $this->rolledback = false;
        $this->completed = false;
    }

    public function beginTransaction()
    {
        if (! ($this->requested() > 1)) {
            $this->logger->trace("A new transaction has been created");
            $this->connection = $this->connectionManager->getConnection();
            $this->connection->beginTransaction();
        } else {
            $this->logger->trace("The transaction has been requested again. No: " . $this->getCounter());
        }
    }

    public function commit()
    {
        if ($this->rolledback) {
            throw new RuntimeException("The transaction has been rolledback");
        }
        $this->logger->trace("The transaction has been committed. No: " . $this->getCounter());
        if ($this->released() == 0) {
            $this->completed = true;
            $this->connection->commit();
        }
    }

    public function rollback()
    {
        $this->logger->trace("The transaction has been rolledback. No: " . $this->getCounter());
        $this->rolledback = true;
        if ($this->released() == 0) {
            $this->completed = true;
            $this->connection->rollback();
        }
    }

    private function requested()
    {
        return ++ $this->counter;
    }

    private function released()
    {
        return -- $this->counter;
    }

    public function getCounter()
    {
        return $this->counter;
    }

    public function release()
    {
        $this->logger->trace("The transaction connection has been released. No: " . $this->getCounter());
        if ($this->getCounter() == 0) {
            $this->connectionManager->releaseConnection($this->connection);
        }
    }

    public function isRolledback()
    {
        return $this->rolledback;
    }

    public function isCompleted()
    {
        return $this->completed;
    }
}

?>