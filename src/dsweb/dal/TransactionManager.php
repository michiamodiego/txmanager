<?php
namespace dsweb\dal;

interface TransactionManager
{

    public function doInTransaction($callback);

    public function doInTransactionWithResult($callback);
}

?>