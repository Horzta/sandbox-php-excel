<?php
require __DIR__ . '/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\IOFactory;
use Lib\Helper;

ini_set('memory_limit', '-1');
while (true) {
    foreach (Helper::listFiles('test') as $file) {
        Helper::displayStartFile($file);

        $reader = IOFactory::createReader('Xlsx');
        Helper::displayMemoryUsage("Loaded Reader");
        
        $reader->setReadDataOnly(true);
        $excelObj = $reader->load('/var/excel/test/' . $file);
        Helper::displayMemoryUsage("Loaded Object");

        foreach ($excelObj->getAllSheets() as $sheet) {
            Helper::displayMemoryUsage("Loaded Sheet");
        
            $sheetRows = $sheet->toArray();

            foreach ($sheetRows as $row) {
                // If you want to check if the data per row is being retrieved
                // you can uncomment this block, but this will consume additional resources on
                // Docker's ram
                // Helper::display(str_pad("\r", 100, " ", STR_PAD_LEFT));
                // Helper::display(
                //     "Reading Line:" . str_pad($row[0], 10, " ", STR_PAD_LEFT) .
                //     str_pad($row[3], 30, " ", STR_PAD_LEFT) .
                //     " Memory: " . Helper::convertMemory(memory_get_usage()) .
                //     " Memory (Total): " . Helper::convertMemory(memory_get_usage(true))
                // );
            }
        
            Helper::display(PHP_EOL);
            Helper::displayMemoryUsage("Ended Sheet");
        }
        
        $excelObj->disconnectWorksheets();
        unset($excelObj);
        Helper::displayMemoryUsage("Unloaded Object");
        
        unset($reader);
        Helper::displayMemoryUsage("Unloaded Reader");

        gc_collect_cycles();
        Helper::displayMemoryUsage("Garbage Collected");

        Helper::displayEndFile($file);
    }

    Helper::displayMemoryUsage("Sleeping");
    sleep(300); //Sleep for 5 minutes so that we don't continously use CPU while simulating a worker service
}
