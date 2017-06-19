<?php include('admin-header.php'); ?>
<?php include('admin-nav.php'); ?>	

<?php
//which post are we editing?
$post_id = $_GET['post_id'];

include('admin-edit-parse.php'); 

//get all the info about this post
echo $query = "SELECT * FROM posts
			WHERE post_id = $post_id
			LIMIT 1";
$result = $db->query($query);

?>

	<main role="main">
		<section class="panel important">
		<?php 
		if( $result->num_rows >= 1 ){ 
			$row = $result->fetch_assoc();
		?>
			<h2>Edit Post</h2>

			<?php show_feedback( $feedback, $errors ); ?>

<form action="<?php echo $_SERVER['PHP_SELF']; ?>?post_id=<?php echo $post_id; ?>" method="post">
				<div class="twothirds">
					<label for="the_title">Title</label>
					<input type="text" name="title" id="the_title" 
						value="<?php echo $row['title']; ?>">

					<label for="the_body">Post Body</label>
					<textarea name="body" id="the_body" rows="10"><?php 
					echo $row['body']; ?></textarea>
				</div>
				<div class="onethird">

					<label for="the_cat">Category</label>
					<?php category_dropdown( $row['category_id'] ); ?>

					<label>
						<input type="checkbox" name="is_published" value="1" <?php 
						if( $row['is_published'] ){ echo 'checked'; }
						 ?>>
						
						Make this post Public
					</label>

					<label>
						<input type="checkbox" name="allow_comments" value="1" <?php if( $row['allow_comments'] ){ echo 'checked'; } 
						?>>
						Allow comments on this post
					</label>

					<input type="submit" value="Save Post">
					<input type="hidden" name="did_edit" value="1">
				</div>
			</form>
		<?php 
		}else{
			echo 'No Post Found';
		} 
		?>
		</section>	
	</main>
<?php include('admin-footer.php'); ?>