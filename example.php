<?php
require ("./autoloader.php");

use dsweb\plog\LoggerFactory;
use dsweb\plog\Logger;
use dsweb\plog\DefaultFileAppender;
use dsweb\plog\LogLevel;
use dsweb\mysqlidalimp\MySqliConnectionFactory;
use dsweb\dal\DefaultConnectionManager;
use dsweb\dal\DefaultTransactionManager;
use dsweb\dal\obj\SqlTemplate;
use com\example\service\TransactionalService;
use com\example\service\AnotherTransactionalService;

LoggerFactory::setFactory(function ($className) {
    $logger = new Logger(LogLevel::ALL, $className, array(
        new DefaultFileAppender("d/m/Y H:i:s", "/yourpath/log.log")
    ));
    return $logger;
});

$connectionFactory = new MySqliConnectionFactory("localhost", "yourdb", "username", "password");
$connectionManager = new DefaultConnectionManager($connectionFactory);
$txManager = new DefaultTransactionManager($connectionManager);
$sqlTemplate = new SqlTemplate($connectionManager);

$anotherTxService = new AnotherTransactionalService($txManager, $sqlTemplate);
$aService = new TransactionalService($txManager, $sqlTemplate, $anotherTxService);

try {
    // Remove to understand :D. Do not forget to comment $aService->anExceptionalMethod();
    // $aService->aSuccessfulMethod();
    $aService->anExceptionalMethod();
} catch (Exception $e) {
    print_r($e);
}