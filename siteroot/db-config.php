<?php
$database 	= 'melissa_blog_0517';
$username 	= 'melissa_blog0517';
$password 	= 'YA2p6Q7EwDLTuY9Y';
$db_host 	= 'localhost';

//connect to the database
$db = new mysqli( $db_host, $username, $password, $database );

//check to make sure it worked
if( $db->connect_errno > 0 ){
	die('Error connecting to database');
}



//no close php