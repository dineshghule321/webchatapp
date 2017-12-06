
Project Name :Chat Book
Project Url: http://localhost/webchatapp/views/user/login.php

*************************************** start config *********************************************

Download Zip file OR clone github link in your server HTML directory.

Github Link :

*copy database file from root folder I have added as webchat import in your local database;

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
        "db_name" => "webchat",
        "db_user" => "root",
        "db_password" => "",
        "db_port" => "3306"
    );

    *db user name is :root
    *db password is :
    *db_port is :3306

*************************************** start config *********************************************

*************************************** run system ***********************************************
Enter following URL in browser:
Project Url: http://localhost/webchatapp/views/user/login.php

----------------------------------------------------------------------------------
Test App Using Below Data :

User at one end:
Put email as for login : dineshghule321@gmail.com
Password :11111111

User at other end:
Put email as for login : vikas@grr.la
Password :vikas
----------------------------------------------------------------------------------
App Features:

I have already added 3 contacts in each user list.

1] User Need to Signup with email and password

  For password encryption I have used sha1 and md5 dual encryption with added salt

2] Then User can Login to to his account

3] To start chat user first need to add contacts in his contact list
    1] User can add contact
    2] User can delete his contacts
    3] User can edit his contacts
    4] User can search contact by name and mobile number
    
    User can add new contacts to his account.
    But while adding contact to list that contact should be registered over the
    Chat App first then and only then we can add contact to our contact list.
    
4] On chat window user will get his contact list at left side and chat data at 
    right side
    1] on left window user can search contact by email
    2] By click on contact chat data related to that contact will displayed at right side
    3] on chat window user can see user last active status and online offline status
    4] in chat user can send text ,Images ,document (pdf,docx)
    
 5] Used color code #ff5900 for most design in app
 
 6] also from navigation bar user can change his profile picture
 
 7] added autoscroll for chat window and contact window

*************************************** run system ***********************************************


