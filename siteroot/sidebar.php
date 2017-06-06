<aside class="sidebar">

	<section class="search-bar">
		<form action="search.php" method="get">
			<label>Search:</label>
			<input type="search" name="phrase">
			<input type="submit" value="Search">
		</form>		
	</section>

	
	<?php //get the titles of up to 5 recent published posts
	$query 	= "SELECT title, post_id
				FROM posts
				WHERE is_published = 1
				ORDER BY date DESC
				LIMIT 5";
	$result = $db->query($query);
	//check to see if we got any rows
	if( $result->num_rows >= 1 ){
	 ?>
	<section>
		<h2>Latest Posts</h2>
		<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
			<li>
			<a href="single.php?post_id=<?php echo $row['post_id']; ?>">
				<?php echo $row['title']; ?> 
			</a>
			- <?php count_comments( $row['post_id'] ); ?></li>
		<?php } //end while 
		$result->free();
		?>
		</ul>
	</section>
	<?php } //end if there are rows ?>



	<?php //show up to 5 categories, in alphabetical order by name and count the number of posts in each
	$query 	= "SELECT c.name, COUNT(*) AS total
			FROM categories AS c, posts AS p
			WHERE c.category_id = p.category_id
			GROUP BY c.category_id
			ORDER BY c.name ASC
			LIMIT 5";
	$result = $db->query($query);
	//check to see if we got any rows
	if( $result->num_rows >= 1 ){?>
	<section>
		<h2>Categories</h2>
		<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
			<li><?php echo $row['name'] ?> 
			- <?php echo $row['total']; ?> posts</li>
		<?php }
		$result->free(); ?>
		</ul>
	</section>
	<?php }//end if ?>



	<?php //get up to 10 links, in random order 
	$query 	= "SELECT name, url 
			FROM links
			ORDER BY RAND()
			LIMIT 10";
	$result = $db->query($query);
	//check to see if we got any rows
	if( $result->num_rows >= 1 ){?>
	<section>
		<h2>Links</h2>
		<ul>
		<?php while( $row = $result->fetch_assoc() ){ ?>
			<li>
				<a href="<?php echo $row['url'] ?>">
					<?php echo $row['name']; ?>
				</a>
			</li>
		<?php }
		$result->free(); ?>
		</ul>
	</section>
	<?php } ?>
</aside>