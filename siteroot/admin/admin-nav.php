<nav role='navigation'>
	<ul class="main">
		<li class="dashboard"><a href="index.php">Dashboard</a></li>
		<li class="write"><a href="admin-write.php">Write Post</a></li>

	<?php if( $logged_in_user['is_admin'] ){ ?>
		<li class="edit"><a href="admin-manage-posts.php">Edit Posts</a></li>
		<li class="comments"><a href="admin-comments.php">Comments</a></li>
		<li class="users"><a href="admin-users.php">Manage Users</a></li>
	<?php } ?>

	</ul>
</nav>