@echo off

Rem We're activating colors in the bash so it's easier to differentiate
SETLOCAL EnableExtensions DisableDelayedExpansion

for /F %%a in ('echo prompt $E ^| cmd') do (
  set "ESC=%%a"
)

SETLOCAL EnableDelayedExpansion
Rem End of the colors activation

echo.
echo "     /$$$$$$        /$$                  /$$$$$$                                          "
echo "    /$$__  $$      | $$                 /$$__  $$                                         "
echo "   | $$  \ $$      | $$  /$$$$$$       | $$  \__/$$$$$$   /$$$$$$  /$$$$$$/$$$$   /$$$$$$ "
echo "   | $$$$$$$$      | $$ |____  $$      | $$$$  /$$__  $$ /$$__  $$| $$_  $$_  $$ /$$__  $$"
echo "   | $$__  $$      | $$  /$$$$$$$      | $$_/ | $$$$$$$$| $$  \__/| $$ \ $$ \ $$| $$$$$$$$"
echo "   | $$  | $$      | $$ /$$__  $$      | $$   | $$_____/| $$      | $$ | $$ | $$| $$_____/"
echo "   | $$  | $$      | $$|  $$$$$$$      | $$   |  $$$$$$$| $$      | $$ | $$ | $$|  $$$$$$$"
echo "   |__/  |__/      |__/ \_______/      |__/    \_______/|__/      |__/ |__/ |__/ \_______/"
echo.

Rem We're getting the MySQL credentials so we can create the database
Rem Note : The default value here is localhost and root users
SETLOCAL
    set /p DBHOST=Please enter the Database Host (press enter if it's localhost) : || set DBHOST=localhost
    set /p DBUSER=Please enter the Database User (press enter if it is root user) : || set DBUSER=root
    set /p DBPWD=Please enter the Database Password (press enter if it is root user) : || set DBPWD= 

echo %ESC%[96mCreating a new %ESC%[92mLaravel %ESC%[96mdatabase ...%ESC%[0m

mysql -h %DBHOST% -u %DBUSER% --password=%DBPWD% -e "DROP DATABASE IF EXISTS Laravel;CREATE DATABASE Laravel"

echo %ESC%[96mA new %ESC%[92mLaravel %ESC%[96mdatabase has been created.%ESC%[0m

cd a-la-ferme

call composer install

call npm install

call npm run dev

call php artisan migrate

call php artisan db:seed

ENDLOCAL

pause