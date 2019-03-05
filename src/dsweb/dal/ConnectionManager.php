<?php
namespace dsweb\dal;

interface ConnectionManager
{

    public function getConnection();

    public function releaseConnection(Connection $connection);
}

?>