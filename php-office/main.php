<?php
require __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use Lib\{Helper, Logger};


ini_set('memory_limit', '-1');
$helper = new Helper(new Logger('php-office', __DIR__));

while (true) {
    foreach ($helper->listFiles('test') as $file) {
        $helper->logStartFile($file);

        $reader = IOFactory::createReader('Xlsx');
        $helper->logMemoryUsage("Loaded Reader");
        
        $reader->setReadDataOnly(true);
        $excelObj = $reader->load('/var/excel/test/' . $file);
        $helper->logMemoryUsage("Loaded Object");

        foreach ($excelObj->getAllSheets() as $sheet) {
            $helper->logMemoryUsage("Loaded Sheet");
        
            $sheetRows = $sheet->toArray();

            foreach ($sheetRows as $row) {
                // If you want to check if the data per row is being retrieved
                // you can uncomment this block, but this will consume additional resources on
                // Docker's ram
                // $helper->log(
                //     "Reading Line:" . str_pad($row[0], 10, " ", STR_PAD_LEFT) .
                //     str_pad($row[3], 30, " ", STR_PAD_LEFT) .
                //     " Memory: " . $helper->convertMemory(memory_get_usage()) .
                //     " Memory (Total): " . $helper->convertMemory(memory_get_usage(true))
                // );
            }

            $helper->logMemoryUsage("Ended Sheet");
        }
        
        $excelObj->disconnectWorksheets();
        unset($excelObj);
        $helper->logMemoryUsage("Unloaded Object");
        
        unset($reader);
        $helper->logMemoryUsage("Unloaded Reader");

        $helper->logEndFile($file);
    }

    gc_collect_cycles();
    $helper->logMemoryUsage("Garbage Collected");

    $helper->logMemoryUsage("Sleeping");
    sleep(300); //Sleep for 5 minutes so that we don't continously use CPU while simulating a worker service
}
