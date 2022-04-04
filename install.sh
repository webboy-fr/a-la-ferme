
read -p "
                       ____                                      __                               ___              \n
   /'\_/`\             /\  _`\                                   /\ \                             /\_ \             \n
  /\      \     __     \ \ \L\_\ __   _ __    ___ ___      __    \ \ \        ___     ___     __  \//\ \      __    \n
  \ \ \__\ \  /'__`\    \ \  _\/'__`\/\`'__\/' __` __`\  /'__`\   \ \ \  __  / __`\  /'___\ /'__`\  \ \ \   /'__`\  \n
   \ \ \_/\ \/\ \L\.\_   \ \ \/\  __/\ \ \/ /\ \/\ \/\ \/\  __/    \ \ \L\ \/\ \L\ \/\ \__//\ \L\.\_ \_\ \_/\  __/  \n
    \ \_\\ \_\ \__/.\_\   \ \_\ \____\\ \_\ \ \_\ \_\ \_\ \____\    \ \____/\ \____/\ \____\ \__/.\_\/\____\ \____\ \n
     \/_/ \/_/\/__/\/_/    \/_/\/____/ \/_/  \/_/\/_/\/_/\/____/     \/___/  \/___/  \/____/\/__/\/_/\/____/\/____/ \n
                                                                                                                    \n
" maferme

echo $maferme

# We are getting the MySQL credentials so we can create the database
# Note : The default value here is localhost and root users

export -p DBHOST=Please enter the Database Host (press enter if it\'s localhost) : || export DBHOST=localhost
export -p DBUSER=Please enter the Database User (press enter if it is root user) : || export DBUSER=root
export -p DBPWD=Please enter the Database Password (press enter if it is root user) : || export DBPWD= 

echo Creating a new mafermelocale database ...

mysql -h $DBHOST -u $DBUSER --password=$DBPWD -e "DROP DATABASE IF EXISTS mafermelocale; CREATE DATABASE mafermelocale"

echo A new mafermelocale database has been created.

cd api-mafermelocale

cp .env.example .env

source or . composer install

source or . php artisan migrate

source or . php artisan db:seed

source or . php artisan serve

pause