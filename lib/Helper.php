<?php
namespace Lib;

class Helper {
    public static function listFiles(string $dir): array
    {
        return array_diff(scandir($dir), array('.', '..'));
    }

    public static function convertMemory($size)
    {
        $unit=array('b','kb','mb','gb','tb','pb');
        return @round($size/pow(1024,($i=floor(log($size,1024)))),2).' '.$unit[$i];
    }

    public static function displayStartFile(string $filename)
    {
        self::display(str_pad("-- START: {$filename} ", 100, "-", STR_PAD_RIGHT)  . PHP_EOL);
    }

    public static function displayEndFile(string $filename)
    {
        self::display(str_pad("-- END: {$filename} ", 100, "-", STR_PAD_RIGHT)  . PHP_EOL);        
    }

    public static function displayMemoryUsage(string $action)
    {
        self::display($action . ": " . self::convertMemory(memory_get_usage()) . PHP_EOL);
        self::display($action . " TOTAL: " . self::convertMemory(memory_get_usage(true)) . PHP_EOL);
    }

    public static function display(string $str): void
    {
        echo $str;
    }
}
