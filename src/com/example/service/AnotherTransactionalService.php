<?php
namespace com\example\service;

use dsweb\dal\DefaultTransactionManager;
use dsweb\dal\obj\SqlTemplate;

class AnotherTransactionalService
{

    private $txManager;

    private $sqlTemplate;

    public function __construct(DefaultTransactionManager $txManager, SqlTemplate $sqlTemplate)
    {
        $this->txManager = $txManager;
        $this->sqlTemplate = $sqlTemplate;
    }

    public function aSuccessfulMethod()
    {
        $sqlTemplate = $this->sqlTemplate;
        $this->txManager->doInTransaction(function () use ($sqlTemplate) {
            $time = date("Y-m-d H:i:s");
            $sqlTemplate->upsert("insert into athing (afield1, afield2) values('afield1: ${time}', 'afield2: ${time}')");
        });
    }

    public function anExceptionalMethod()
    { // :D
        $sqlTemplate = $this->sqlTemplate;
        $this->txManager->doInTransaction(function () use ($sqlTemplate) {
            $time = date("Y-m-d H:i:s");
            $sqlTemplate->upsert("insert into athing (afield1, afield2) values('afield1: ${time}', 'afield2: ${time}')");
            throw new \RuntimeException("A self-imposed exception.");
        });
    }
}

?>