<?php include('admin-header.php'); ?>
<?php include('admin-nav.php'); ?>	

<?php 
//delete parser
if( $_POST['did_delete'] ){
	//which posts did they check?
	$list = $_POST['delete'];
	foreach( $list as $post_id ){
		$query = "DELETE FROM posts 
					WHERE post_id = $post_id";
		$result = $db->query($query);
	}
} //end of delete parser
 ?>
	<main role="main">
		<section class="panel important">
			<h2>Manage Posts</h2>

			<?php //get all the posts that this user can edit 
			if( $logged_in_user['is_admin'] ){
				$query = "SELECT posts.title, posts.date, posts.is_published, posts.post_id, users.username, categories.name AS catname
							FROM posts, users, categories
							WHERE posts.user_id = users.user_id
							AND posts.category_id = categories.category_id
							ORDER BY posts.date DESC";
				$result = $db->query($query);
				if( $result->num_rows >= 1 ){			
			?>
			<form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post">
				<input type="hidden" name="did_delete" value="1">
				<table>
					<tr>
						<th>Title</th>
						<th>Date</th>
						<th>Author</th>
						<th>Status</th>
						<th>Category</th>
						<th><button type="submit"><i class="fa fa-trash fa-2x"></i></button></th>
					</tr>

					<?php while( $row = $result->fetch_assoc() ){ ?>
					<tr>
						<td><a href="admin-edit.php?post_id=<?php 
							echo $row['post_id']; ?>">
							<?php echo $row['title']; ?>
						</a></td>
						<td><?php echo convert_date($row['date']); ?></td>
						<td><?php echo $row['username']; ?></td>
						<td><?php echo $row['is_published'] == 1 ? 'Public' : 
								'<b>Draft</b>'; ?></td>
						<td><?php echo $row['catname']; ?></td>
						<td><input type="checkbox" name="delete[]" value="<?php 
							echo $row['post_id']; ?>"></td>
					</tr>
					<?php }//end while ?>
				</table>
			</form>
			<?php
				}else{
					echo 'No posts to show';
				} //end if there are rows
			}else{
				echo 'You do not have permission to edit any posts';
			} //end if user is admin ?>
		</section>	
	</main>
<?php include('admin-footer.php'); ?>