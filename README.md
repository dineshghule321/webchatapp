
Project Name :Contact Book
Project Url: http://localhost/contact_book/views/user/login.php

*************************************** start config *********************************************

Download Zip file OR clone github link in your server HTML directory.

Github Link :

*copy database file from root folder I have added as contact_book import in your local database;

Directory Structure:

contact_book ---root_directory
	|
	----asset
	|
	----config
	|
	----controllers
	|
	----helpers
	|
	----models
	|
	----views

Note: 

1]config/config.php 
		
		file contains global configuration parameters.

2]config/DB.php 
		
		file contains global configuration database with PDO connection.

	* put DB credentails in array given for hosts.

	private $dbHost=array(
        "db_host_primary" => "localhost",
        "db_host_secondary" => "localhost"
    );

    * put DB credentails in array given for system.

	  private $dbSystem = array(
        "db_name" => "contact_book",
        "db_user" => "dbuser",
        "db_password" => "dbuser@123",
        "db_port" => "3306"
    );

    *db user name is :dbuser
    *db password is :dbuser@123
    *db_port is :3306

*************************************** start config *********************************************

*************************************** run system ***********************************************
Enter following URL in browser:
Project Url: http://localhost/contact_book/views/user/login.php

Put email as : dineshghule321@gmail.com
Password :dineshghule

system login done.
*************************************** run system ***********************************************


