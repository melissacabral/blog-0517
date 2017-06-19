<?php include('admin-header.php'); ?>
<?php include('admin-nav.php'); ?>	

<?php include('admin-write-parse.php'); ?>

	<main role="main">
		<section class="panel important">
			<h2>Write a Post</h2>

			<?php show_feedback( $feedback, $errors ); ?>

			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
				<div class="twothirds">
					<label for="the_title">Title</label>
					<input type="text" name="title" id="the_title">

					<label for="the_body">Post Body</label>
					<textarea name="body" id="the_body" rows="10"></textarea>
				</div>
				<div class="onethird">

					<label for="the_cat">Category</label>
					<?php category_dropdown(); ?>

					<label>
						<input type="checkbox" name="is_published" value="1" checked>
						Make this post Public
					</label>

					<label>
						<input type="checkbox" name="allow_comments" value="1" checked>
						Allow comments on this post
					</label>

					<input type="submit" value="Save Post">
					<input type="hidden" name="did_post" value="1">
				</div>
			</form>
		</section>	
	</main>
<?php include('admin-footer.php'); ?>