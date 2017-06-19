<?php include('admin-header.php'); ?>
<?php include('admin-nav.php'); ?>	
<main role="main">
<?php include('admin-edit-profile-parse.php'); ?>

	
		<section class="panel important">
			<h2>Edit Your Profile</h2>
			<div class="onethird">

				<?php show_feedback($statusmsg, array()); ?>
				
				<!-- You must have the enctype attr in order to handle file data -->
				<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" 
					enctype="multipart/form-data">
					
					<label>Upload a Photo:</label>
					<input type="file" name="uploadedfile" required>

					<input type="submit" value="Edit Profile">

					<input type="hidden" name="did_upload" value="1">
				</form>
			</div>

			<div class="twothirds">
				<?php show_profile_pic($logged_in_user['user_id'], 'medium_img'); ?>
			</div>
		</section>	

	</main>
<?php include('admin-footer.php'); ?>