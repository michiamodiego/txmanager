<?php
namespace dsweb\mysqlidalimp;

use dsweb\dal\ConnectionFactory;

class MySqliConnectionFactory implements ConnectionFactory
{

    private $server;

    private $database;

    private $username;

    private $password;

    public function __construct($server, $database, $username, $password)
    {
        $this->server = $server;
        $this->database = $database;
        $this->username = $username;
        $this->password = $password;
    }

    public function getConnection()
    {
        $connection = new MySqliConnection($this->server, $this->database, $this->username, $this->password);
        return $connection;
    }
}

?>