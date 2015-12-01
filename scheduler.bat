@echo off

cd c:\lamp\www\cw5
C:\lamp\bin\php\php-5.6.3\php.exe artisan schedule:run 1>> NUL 2>&1
