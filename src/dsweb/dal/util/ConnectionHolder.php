<?php
namespace dsweb\dal\util;

use dsweb\dal\Connection;

class ConnectionHolder
{

    private $connection;

    private $counter;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
        $this->counter = 0;
    }

    public function getConnection()
    {
        return $this->connection;
    }

    public function requested()
    {
        return ++ $this->counter;
    }

    public function released()
    {
        return -- $this->counter;
    }

    public function getCounter()
    {
        return $this->counter;
    }
}

?>