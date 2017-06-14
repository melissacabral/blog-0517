<?php 
//supress Notice: messages
error_reporting( E_ALL & ~E_NOTICE ); 

//we need to use session data on this page. 
session_start();

require('db-config.php');
include_once('functions.php');
include('login-parse.php');
?>
<!DOCTYPE html>
<html>
<head>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta charset="utf-8">
	<title>Log in to your account</title>
	<link rel="stylesheet" type="text/css" href="styles/login-style.css">
</head>
<body>

	
		<h1>Log in to your account</h1>

		<?php show_feedback( $error_message, array() ); ?>

		<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">

			<label for="the_username">Username</label>
			<input type="text" name="username" id="the_username" required>

			<label for="the_password">Password</label>
			<input type="password" name="password" id="the_password" required>

			<input type="submit" value="Log In">

			<input type="hidden" name="did_login" value="1">
		</form>
	

	<footer>
		This site uses cookies to improve your experience. 
	</footer>
</body>
</html>