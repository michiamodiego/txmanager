<?php
namespace dsweb\dal;

interface Connection
{

    function beginTransaction();

    function commit();

    function rollback();

    function upsert($query);

    function execute($query);

    function close();
}

?>