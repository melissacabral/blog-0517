<?php 
session_start();
require('../db-config.php');
include_once('../functions.php');

//make sure the person viewing the admin panel is logged in!
if( isset($_SESSION['user_id']) AND isset($_SESSION['secret_key']) ){
	//check for a match in the DB
	$sess_user_id = $_SESSION['user_id'];
	$sess_secret_key = $_SESSION['secret_key'];

	$query = "SELECT * FROM users
			WHERE user_id = $sess_user_id
			AND secret_key = '$sess_secret_key'
			LIMIT 1";
	$result = $db->query($query);
	if( !$result ){
		//TODO: for testing, show a message if bad query. change this to a redirect later.
		die('bad db result');
	}

	if($result->num_rows == 1){
		//success - we have a logged in user! Set up the user info for later use
		$logged_in_user = $result->fetch_assoc();
	}else{
		//TODO: error - credentials don't match anyone in the db.
		//change this to a redirect later.
		die('not found in db');
	}

}else{
	//no session vars present - send them to login form
	header('Location:../login.php');
}
?>
<!doctype html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Admin Panel</title>
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.4.0/css/font-awesome.min.css">
	<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" type="text/css" href="css/admin-style.css">
</head>
<body>
	<header role="banner">
		<h1>Admin Panel</h1>
		<ul class="utilities">
			<li class="users"><a href="#">My Account</a></li>
			<li class="logout warn"><a href="">Log Out</a></li>
		</ul>
	</header>