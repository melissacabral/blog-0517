<?php include('header.php'); ?>

<main class="content">
	<?php 
	//get the two most recent posts that are published
	$query = 	"SELECT posts.title, posts.date, posts.body, categories.name, posts.post_id
				FROM posts, categories
				WHERE posts.is_published = 1
				AND categories.category_id = posts.category_id
				ORDER BY posts.date DESC
				LIMIT 10";
	//run the query on the DB
	$result = $db->query($query);
	//check to see if the query returned any rows
	if( $result->num_rows >= 1 ){
		//loop through all the rows
		while( $row = $result->fetch_assoc() ){
	?>
	<article>
		<h2>
			<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
				<?php echo $row['title']; ?>	
			</a>
		</h2>
		<div class="post-info"> Posted on 
			<?php echo convert_date($row['date']); ?> 
			in <?php echo $row['name']; ?>
			- <?php count_comments( $row['post_id'], ' comment on this post', 
			' comments on this post' ); ?>
		</div>

		<p><?php echo $row['body']; ?></p>
	</article>
	<?php 
		} //end while
		//clean up after we're done with these results
		$result->free();
	}else{
		echo 'No Posts found.';
	} ?>

</main>

<?php include('sidebar.php'); ?>

<?php include('footer.php'); ?>