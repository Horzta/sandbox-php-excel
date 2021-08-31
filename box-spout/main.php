<?php
require __DIR__ . '/vendor/autoload.php';
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Lib\Helper;

ini_set('memory_limit', '-1');

while (true) {
    foreach (Helper::listFiles('test') as $file) {
        Helper::displayStartFile($file);
    
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open('/var/excel/test/' . $file);
        Helper::displayMemoryUsage("Loaded Reader");
    
        foreach ($reader->getSheetIterator() as $sheet) {
            Helper::displayMemoryUsage("Loaded Sheet");
            Helper::display(PHP_EOL);
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->getCells();

                // If you want to check if the data per row is being retrieved
                // you can uncomment this block, but this will consume additional resources on
                // Docker's ram
                // Helper::display(str_pad("\r", 100, " ", STR_PAD_LEFT));
                // Helper::display(
                //     "Reading Line:" . str_pad($cells[0]->getValue(), 10, " ", STR_PAD_LEFT) .
                //     str_pad($cells[3]->getValue(), 30, " ", STR_PAD_LEFT) .
                //     " Memory: " . Helper::convertMemory(memory_get_usage()) .
                //     " Memory (Total): " . Helper::convertMemory(memory_get_usage(true))
                // );

            }
            Helper::display(PHP_EOL);
            Helper::displayMemoryUsage("Ended Sheet");
        }
        
        
        $reader->close();
        Helper::displayMemoryUsage("Closed Reader");
        
        unset($reader);
        Helper::displayMemoryUsage("Unset Reader");
        Helper::displayEndFile($file);
    }
    Helper::displayMemoryUsage("Sleeping");
    sleep(300); //Sleep for 5 minutes so that we don't continously use CPU while simulating a worker service
}
