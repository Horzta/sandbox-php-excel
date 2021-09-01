# Setup
1. Clone Repository
2. Run `docker compose up --build` within the cloned repository

* The Scripts should automatically run and give you memory usage logs so that you can compare the two excel libraries.
* The Scripts will run all the excel files under `test` and will sleep for 5 minutes before doing it again to simulate a long running script.

# Introduction
This is a simple PHP Library to check the excel libraries. We were having problems with `phpoffice/phpspreadsheet` because of how high its idle memory is for long running scripts. This is a simple exercise to look at other libraries and compare.

# Test results
The [Log Sample Files](https://github.com/Horzta/sandbox-php-excel/tree/master/logs) show
* The system idles at 1.22mb and reserves 2mb for [Box/Spout](https://github.com/box/spout)
* The system idles at 110.77mb  and reserves 340mb for [PHPOffice/PhpSpreadsheet](https://github.com/PHPOffice/PhpSpreadsheet)
* On the Docker Desktop Statistics, the system that uses PhpSpreadsheet reserves up to 1.4GB for a 4MB excel file  (This actually gets higher as the excel file gets larger)
* On the Docker Desktop Statistics, the system that uses Box/Spout just uses 6.3MB for a 4MB excel file (This doesn't get bigger no matter how large the excel file is)