<?php 
/*
Display output
This file stays on the server and has no doctype/page structure.
It simply runs a query to get all the posts in a category
and hands back the HTML content for the posts
*/
require('db-config.php');
include_once('functions.php');

//just to test a slow connection - put the server to sleep for 5 seconds.
//remove this from the final code!!!
sleep(5);

//the category ID that the user clicked (from the interface file)
$category_id = $_REQUEST['catid'];

//query to get all published posts in a category
$query = "SELECT posts.title, posts.date, users.username, posts.body 
		FROM posts, users
		WHERE posts.user_id = users.user_id
		AND posts.category_id = $category_id
		ORDER BY date DESC
		LIMIT 10";
$result = $db->query($query);

if( ! $result ){
	die( $db->error );
}

if($result->num_rows >= 1){
	while( $row = $result->fetch_assoc() ){
?>

<article>
	<h2><?php echo $row['title']; ?></h2>
	<div class="date"><?php echo convert_date( $row['date'] ); ?></div>
	<div class="author"><?php echo $row['username']; ?></div>
	<p><?php echo $row['body']; ?></p>
</article>

<?php
	} //end while 
}else{
	echo 'No posts in this category';
} ?>