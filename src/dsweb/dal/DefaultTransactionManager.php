<?php
namespace dsweb\dal;

use dsweb\dal\util\TransactionUtils;

class DefaultTransactionManager implements TransactionManager
{

    private $connectionManager;

    public function __construct(ConnectionManager $connectionManager)
    {
        $this->connectionManager = $connectionManager;
    }

    public function doInTransaction($callback)
    {
        TransactionUtils::doInTransaction($this->connectionManager, $callback);
    }

    public function doInTransactionWithResult($callback)
    {
        return TransactionUtils::doInTransactionWithResult($this->connectionManager, $callback);
    }
}

?>