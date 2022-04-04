@ECHO OFF

REM We're activating colors in the bash so it's easier to differentiate
SETLOCAL EnableExtensions DisableDelayedExpansion

for /F %%a in ('echo prompt $E ^| cmd') do (
  SET "ESC=%%a"
)

SETLOCAL EnableDelayedExpansion
REM End of the colors activation

ECHO.
ECHO.
ECHO                        ____                                      __                               ___              
ECHO   /'\_/`\             /\  _`\                                   /\ \                             /\_ \             
ECHO  /\      \     __     \ \ \L\_\ __   _ __    ___ ___      __    \ \ \        ___     ___     __  \//\ \      __    
ECHO  \ \ \__\ \  /'__`\    \ \  _\/'__`\/\`'__\/' __` __`\  /'__`\   \ \ \  __  / __`\  /'___\ /'__`\  \ \ \   /'__`\  
ECHO   \ \ \_/\ \/\ \L\.\_   \ \ \/\  __/\ \ \/ /\ \/\ \/\ \/\  __/    \ \ \L\ \/\ \L\ \/\ \__//\ \L\.\_ \_\ \_/\  __/  
ECHO    \ \_\\ \_\ \__/.\_\   \ \_\ \____\\ \_\ \ \_\ \_\ \_\ \____\    \ \____/\ \____/\ \____\ \__/.\_\/\____\ \____\ 
ECHO     \/_/ \/_/\/__/\/_/    \/_/\/____/ \/_/  \/_/\/_/\/_/\/____/     \/___/  \/___/  \/____/\/__/\/_/\/____/\/____/ 
ECHO.
ECHO.

REM We're getting the MySQL credentials so we can create the database
REM Note : The default value here is localhost and root users

SETLOCAL
    SET /p DBHOST=Please enter the Database Host (press enter if it's localhost) : || SET DBHOST=localhost
    SET /p DBUSER=Please enter the Database User (press enter if it is root user) : || SET DBUSER=root
    SET /p DBPWD=Please enter the Database Password (press enter if it is root user) : || SET DBPWD= 

ECHO %ESC%[96mCreating a new %ESC%[92mmafermelocale %ESC%[96mdatabase ...%ESC%[0m

mysql -h %DBHOST% -u %DBUSER% --password=%DBPWD% -e "DROP DATABASE IF EXISTS mafermelocale; CREATE DATABASE mafermelocale"

ECHO %ESC%[96mA new %ESC%[92mmafermelocale %ESC%[96mdatabase has been created.%ESC%[0m

CD api-mafermelocale

COPY .env.example .env

CALL composer install

CALL php artisan migrate

CALL php artisan db:seed

CALL php artisan serve

ENDLOCAL

PAUSE