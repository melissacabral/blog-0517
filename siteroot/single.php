<?php 
include('header.php'); 
include('comment-parse.php');

//which post are we trying to show
$post_id = $_GET['post_id'];
?>

<main class="content">
	<?php 
	//get all the info about THIS post. make sure it is a published post
	$query = "SELECT posts.title, posts.body, posts.date, users.username
				FROM posts, users
				WHERE posts.post_id = $post_id
				AND posts.user_id = users.user_id
				AND posts.is_published = 1
				LIMIT 1";
	$result = $db->query($query);
	//check it
	if( $result->num_rows == 1 ){
		while( $row = $result->fetch_assoc() ){
	 ?>
	
	<article>
		<h2><?php echo $row['title']; ?></h2>

		<?php echo $row['body']; ?>
		
		<div class="author">Written by: <?php echo $row['username']; ?></div>
		<div class="date"><?php echo convert_date( $row['date'] ); ?></div>
	</article>

	<?php 
	//get all the approved comments on THIS post, newest last
	$query = "SELECT comments.name, comments.body, comments.date
				FROM comments
				WHERE post_id = $post_id
				AND is_approved = 1
				ORDER BY date ASC
				LIMIT 20";
	$result = $db->query($query);
	if( $result->num_rows >= 1 ){
	?>
	<section class="comments-list">
		<h2>Comments:</h2>

		<ul>
			<?php while( $row = $result->fetch_assoc() ){ ?>
			<li class="one-comment">
				<h3><?php echo $row['name']; ?></h3>
				<p><?php echo $row['body']; ?></p>
				<div class="date"><?php echo convert_date( $row['date'] ); ?></div>
			</li>
			<?php } //end while ?>
		</ul>
	</section>
	<?php } //end if comments ?>

	<section class="commentform">
		<h2>Leave a Comment</h2>

		<?php show_feedback( $feedback, $errors ); ?>

		<form action="single.php?post_id=<?php echo $post_id; ?>" method="post" novalidate>
			<label for="the_name">Name:</label>
			<input type="text" name="name" id="the_name" required>

			<label for="the_email">Email:</label>
			<input type="email" name="email" id="the_email" required>

			<label for="the_comment">Comment:</label>
			<textarea name="comment" id="the_comment" required></textarea>

			<input type="submit" value="Post Comment">
			<input type="hidden" name="did_comment" value="1">

			<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
		</form>

	</section>

	<?php 
		} //end while
	} //end if one post to show
	else{
		echo 'Invalid post.';
	} 
	?>

</main>

<?php include('sidebar.php'); ?>
<?php include('footer.php'); ?>