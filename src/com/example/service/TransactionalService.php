<?php
namespace com\example\service;

use dsweb\dal\DefaultTransactionManager;
use dsweb\dal\obj\SqlTemplate;

class TransactionalService
{

    private $txManager;

    private $sqlTemplate;

    private $anotherTransactionalService;

    public function __construct(DefaultTransactionManager $txManager, SqlTemplate $sqlTemplate, AnotherTransactionalService $anotherTransactionalService)
    {
        $this->txManager = $txManager;
        $this->sqlTemplate = $sqlTemplate;
        $this->anotherTransactionalService = $anotherTransactionalService;
    }

    public function aSuccessfulMethod()
    {
        $aService = $this->anotherTransactionalService;
        $this->txManager->doInTransaction(function () use ($aService) {
            $aService->aSuccessfulMethod();
        });
    }

    public function anExceptionalMethod()
    { // :D
        $aService = $this->anotherTransactionalService;
        $this->txManager->doInTransaction(function () use ($aService) {
            $aService->anExceptionalMethod();
        });
    }
}

?>