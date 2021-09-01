<?php
namespace Lib;
use Lib\Logger;

class Helper {
    private $logger;

    function __construct(Logger $logger)
    {
        $this->logger = $logger;
    }


    public function listFiles(string $dir): array
    {
        return array_diff(scandir($dir), array('.', '..'));
    }

    public function convertMemory($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    public function logStartFile(string $filename)
    {
        self::log(str_pad("-- START: {$filename} ", 100, "-", STR_PAD_RIGHT)  . PHP_EOL);
    }

    public function logEndFile(string $filename)
    {
        self::log(str_pad("-- END: {$filename} ", 100, "-", STR_PAD_RIGHT)  . PHP_EOL);        
    }

    public function logMemoryUsage(string $action)
    {
        self::log($action . ": " . self::convertMemory(memory_get_usage()) . PHP_EOL);
        self::log($action . " TOTAL: " . self::convertMemory(memory_get_usage(true)) . PHP_EOL);
    }

    public function log(string $str): void
    {
        $this->logger->log($str);
    }
}
