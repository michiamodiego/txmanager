<?php
namespace dsweb\dal;

use dsweb\dal\util\ConnectionUtils;

class DefaultConnectionManager implements ConnectionManager
{

    private $connectionFactory;

    public function __construct(ConnectionFactory $connectionFactory)
    {
        $this->connectionFactory = $connectionFactory;
    }

    public function getConnection()
    {
        return ConnectionUtils::getConnection($this->connectionFactory);
    }

    public function releaseConnection(Connection $connection)
    {
        return ConnectionUtils::releaseConnection($connection);
    }
}

?>