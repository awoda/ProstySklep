<?php 
require "connect_to_mysql.php";  

$sqlCommand = "CREATE TABLE admin (
		 		 id int(11) NOT NULL auto_increment,
				 username varchar(24) NOT NULL,
		 		 password varchar(24) NOT NULL,
		 		 last_log_date date NOT NULL,
		 		 PRIMARY KEY (id),
		 		 UNIQUE KEY username (username)
		 		 ) ";
if (mysql_query($sqlCommand)){ 
    echo "Your admin table has been created successfully!"; 
} else { 
    echo "CRITICAL ERROR: admin table has not been created.";
}

$sqlCommand2 = "CREATE TABLE products (
		 		 id int(11) NOT NULL auto_increment,
				 product_name varchar(255) NOT NULL,
		 		 price varchar(16) NOT NULL,
				 details text NOT NULL,
				 category varchar(255) NOT NULL,
				 subcategory varchar(255) NOT NULL,
		 		 date_added date NOT NULL,
		 		 PRIMARY KEY (id),
		 		 UNIQUE KEY product_name (product_name)
		 		 ) ";
if (mysql_query($sqlCommand2)){ 
    echo "Your products table has been created successfully!"; 
} else { 
    echo "CRITICAL ERROR: products table has not been created.";
}

$sqlCommand3 = "CREATE TABLE transactions (
		 		 id int(11) NOT NULL auto_increment,
				 product_id_array varchar(255) NOT NULL,
		 		 payer_email varchar(255) NOT NULL,
				 first_name varchar(255) NOT NULL,
				 last_name varchar(255) NOT NULL,
				 status int(11) NOT NULL,
				 hash varchar(255) NOT NULL,
		 		 PRIMARY KEY (id)
		 		 ) ";
if (mysql_query($sqlCommand3)){ 
    echo "Your transactions table has been created successfully!"; 
} else { 
    echo "CRITICAL ERROR: transactions table has not been created.";
}

?>