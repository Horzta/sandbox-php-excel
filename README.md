# Setup
1. Clone Repository
2. Run `docker compose up --build` within the cloned repository

* The Scripts should automatically run and give you memory usage logs so that you can compare the two excel libraries.
* The Scripts will run all the excel files under `test` and will sleep for 5 minutes before doing it again to simulate a long running script.

# Introduction
This is a simple PHP Library to check the excel libraries. We were having problems with `phpoffice/phpspreadsheet` because of how high its idle memory is for long running scripts. This is a simple exercise to look at other libraries and compare.
