<?php include('header.php');

//Search configuration
$per_page = 2;

//sanitize the phrase
$phrase = clean_string( $_GET['phrase'] );

//parse the search form if the phrase is not blank
if( $phrase != '' ){
	//get all the posts that contain the phrase
	$query = "SELECT title, date, body, post_id
				FROM posts
				WHERE ( title LIKE '%$phrase%'
				OR body LIKE '%$phrase%' )
				AND is_published = 1
				ORDER BY date DESC";
	$result = $db->query($query);

	$total = $result->num_rows;

	//figure out how many pages we need
	$max_page = ceil( $total / $per_page );
	
	//figure out what page we are on. 
	//query string will look like search.php?phrase=bla&page=2
	if($_GET['page']){
		$current_page = $_GET['page'];
	}else{
		$current_page = 1;
	}

	//check for out of bounds page
	if($current_page > $max_page){
		//change it to the last page if it is out of bounds
		$current_page = $max_page;
	}
	
} //end search parser
?>

<main class="content">
	
	<?php 
	//if there are rows in the results, show them
	if( $total >= 1 ){ 
	?>
	
	<section class="results">
		<h1>Search Results</h1>
		<h2><?php echo $total; ?> posts found.</h2>
		<h3>Showing page <?php echo $current_page; ?> of <?php echo $max_page; ?></h3>
		
		<?php 
		//figure out the offset of this page
		$offset = ( $current_page - 1 ) * $per_page;
		$query .= " LIMIT $offset, $per_page";
		//run the query again with a LIMIT
		$result = $db->query($query);

		while( $row = $result->fetch_assoc() ){ ?>
		<article>
			<h2><a href="single.php?post_id=<?php echo $row['post_id']; ?>">
			<?php echo $row['title']; ?>
			</a></h2>
			<div class="date"><?php echo convert_date($row['date']); ?></div>
			<div class="excerpt"><?php echo substr($row['body'], 0, 250); ?>&hellip;</div>
		</article>
		<?php } //end while ?>

	</section>

	<section class="pagination">
		<?php 
		$previous 	= $current_page - 1;
		$next 		= $current_page + 1;
		

		if( $current_page != 1 ){ ?>
	<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $previous; ?>">
		&larr; Previous Page</a>
		<?php } 

		//loop for numbered pagination
		for ($i = 1; $i <= $max_page; $i++) { 
			?>
			<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $i; ?>">
				<?php echo $i; ?>
			</a>
			<?php
		}

		//show the next button if we're not on the last page
		if( $current_page != $max_page ){ ?>
		<a href="search.php?phrase=<?php echo $phrase; ?>&amp;page=<?php echo $next; ?>">
		Next Page &rarr;</a>
		<?php } ?>

	</section>

	<?php 
	}else{
		echo 'No posts found matching ' . $phrase ;
	} 
	?>
</main>

<?php include('sidebar.php'); ?>
<?php include('footer.php'); ?>