<?php 
error_reporting( E_ALL & ~E_NOTICE ); 
//connect to the db
require('db-config.php');
include_once( 'functions.php' );
?>
<!DOCTYPE html>
<html>
<head>
	<title>My PHP Blog</title>
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	<link href="https://fonts.googleapis.com/css?family=Libre+Franklin:200,400,700" rel="stylesheet">

	<link rel="alternate" type="application/rss+xml" href="rss.php" title="Melissa's Blog Feed">
</head>
<body>

<header class="header">
	<h1>Write about Something</h1>
</header>
