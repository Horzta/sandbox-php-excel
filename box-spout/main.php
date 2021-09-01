<?php
require __DIR__ . '/vendor/autoload.php';
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Lib\{Helper, Logger};


ini_set('memory_limit', '-1');
$helper = new Helper(new Logger('box-sprout', __DIR__));

while (true) {
    foreach ($helper->listFiles('test') as $file) {
        $helper->logStartFile($file);
    
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open('/var/excel/test/' . $file);
        $helper->logMemoryUsage("Loaded Reader");
    
        foreach ($reader->getSheetIterator() as $sheet) {
            $helper->logMemoryUsage("Loaded Sheet");
            foreach ($sheet->getRowIterator() as $row) {
                $cells = $row->getCells();

                // If you want to check if the data per row is being retrieved
                // you can uncomment this block, but this will consume additional resources on
                // Docker's ram
                // $helper->log(
                //     "Reading Line:" . str_pad($cells[0]->getValue(), 10, " ", STR_PAD_LEFT) .
                //     str_pad($cells[3]->getValue(), 30, " ", STR_PAD_LEFT) .
                //     " Memory: " . $helper->convertMemory(memory_get_usage()) .
                //     " Memory (Total): " . $helper->convertMemory(memory_get_usage(true))
                // );

            }
            $helper->logMemoryUsage("Ended Sheet");
        }
        
        
        $reader->close();
        $helper->logMemoryUsage("Closed Reader");
        
        unset($reader);
        $helper->logMemoryUsage("Unset Reader");
        $helper->logEndFile($file);
    }
    gc_collect_cycles();
    $helper->logMemoryUsage("Garbage Collected");

    $helper->logMemoryUsage("Sleeping");
    sleep(300); //Sleep for 5 minutes so that we don't continously use CPU while simulating a worker service
}
