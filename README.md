# sekai-database 世界
Webserver with database for a fictional E-commerce site. 

## Database
Simply import the .sql file found at `/www/database/e-com.sql`, either through phpMyAdmin GUI (or similar) or through the terminal.
Terminal example: `mysql -u root -p newdatabase < /path/to/newdatabase.sql` [source](https://www.digitalocean.com/community/tutorials/how-to-migrate-a-mysql-database-between-two-servers)
Note: You need to have initialized a database already. i.e created one in phpMyAdmin, or similar ways.