# sekai-database 世界
Webserver with database for a fictional E-commerce site. 

## Database
#### Most recent Database
Open phpMyAdmin and import sekai-database.sql from `/www/database/` or 
use the terminal like in the next example.
Note: Unlike the next example a Database will be created with the name `sekai-database` if you do not already have one.

OR

#### Older stable Database
Simply import the .sql file found at `/www/database/e-com.sql`, either through phpMyAdmin GUI (or similar) or through the terminal.
Terminal example: `mysql -u root -p newdatabase < /path/to/newdatabase.sql` [source](https://www.digitalocean.com/community/tutorials/how-to-migrate-a-mysql-database-between-two-servers)
Note: You need to have initialized a database already. i.e created one in phpMyAdmin, or similar ways.

##Source

[php SESSION vaiables](https://www.w3schools.com/php/php_sessions.asp),
[send array in SESSION](https://web.archive.org/web/20080707052007/http://www.phpriot.com/articles/intro-php-sessions/7),
[mysqli](https://www.php.net/manual/en/book.mysqli.php),
[utf-8 array](https://stackoverflow.com/questions/16688179/how-to-convert-php-array-to-utf8),
[utf-8](https://www.w3schools.com/php/func_mysqli_set_charset.asp),
[scrollbar css](https://stackoverflow.com/questions/50817727/change-scrollbar-height)
