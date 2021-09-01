<?php
namespace Lib;

use Monolog\Logger as Monologger;
use Monolog\Handler\StreamHandler;


class Logger
{
    private $logger;

    function __construct(string $servicename, string $mainDir)
    {
        $this->logger = new Monologger($servicename);
        $this->logger->pushHandler(new StreamHandler($mainDir . "/logs/{$servicename}.log", Monologger::DEBUG));
    }

    public function log(string $str): void
    {
        $this->logger->info($str);
    }
}