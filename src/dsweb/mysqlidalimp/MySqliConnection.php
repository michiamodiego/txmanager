<?php
namespace dsweb\mysqlidalimp;

use RuntimeException;
use dsweb\dal\Connection;
use dsweb\plog\LoggerFactory;

class MySqliConnection implements Connection
{

    private $logger;

    private $connection;

    private $transaction;

    public function __construct($server, $database, $username, $password)
    {
        $this->logger = LoggerFactory::getLogger(__CLASS__);
        $this->connection = mysqli_connect($server, $username, $password);
        if ($this->connection === false) {
            throw new RuntimeException("Connect error");
        }
        $result = mysqli_select_db($this->connection, $database);
        if ($result == false) {
            throw new RuntimeException("Connect error");
        }
        $this->logger->trace("A connection has been opened");
    }

    public function beginTransaction()
    {
        if (! mysqli_begin_transaction($this->connection)) {
            throw new RuntimeException("Start transaction error");
        }
        $this->logger->trace("A new transaction has been opened");
    }

    public function commit()
    {
        if (! mysqli_commit($this->connection)) {
            throw new RuntimeException("Commit error");
        }
        $this->logger->trace("The transaction has been committed");
    }

    public function rollback()
    {
        if (! mysqli_rollback($this->connection)) {
            throw new RuntimeException("Rollback error");
        }
        $this->logger->trace("The transaction has been rolledback");
    }

    public function upsert($query)
    {
        $result = mysqli_query($this->connection, $query);
        if ($result === false) {
            throw new RuntimeException("Upsert error");
        }
        $result = mysqli_affected_rows($this->connection);
        if ($result === false) {
            throw new RuntimeException("Upsert error");
        }
        return $result;
    }

    public function execute($query)
    {
        $result = mysqli_query($this->connection, $query);
        if ($result === false) {
            throw new RuntimeException("Query error");
        }
        return new MySqliResultSet($result);
    }

    public function close()
    {
        $result = mysqli_close($this->connection);
        if ($result === false) {
            throw new RuntimeException("Close error");
        }
        $this->logger->trace("The connection has been closed");
    }
}

?>