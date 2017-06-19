<?php
if($_POST['did_edit']){
	//clean all fields
	$title 			= clean_string($_POST['title']);
	$body 			= clean_string($_POST['body']);
	$category_id 	= clean_int($_POST['category_id']);
	$is_published 	= clean_boolean($_POST['is_published']);
	$allow_comments = clean_boolean($_POST['allow_comments']);
	$post_id		= clean_int($_GET['post_id']);

	//validate
	$valid = true;
		//title is blank or longer than 256 chars
		if( $title == '' OR strlen($title) > 256 ){
			$valid = false;
			$errors['title'] = 'Please add a title that is between 1 and 256 characters long.';
		}
		//body is blank
		if( $body == '' ){
			$valid = false;
			$errors['body'] = 'The body of the post cannot be blank.';
		}
		//category id is not blank
		if( $category_id == '' ){
			$valid = false;
			$errors['category_id'] = 'The category cannot be blank.';
		}

		//post_id is not blank
		if( $post_id == '' ){
			$valid = false;
			$errors['post_id'] = 'Post ID is blank';
		}
		
		
	//if it's all valid, add update this post in the DB
	if($valid){
		$query_update = "UPDATE posts
					SET
					title = '$title',
					body = '$body',
					category_id = $category_id,
					is_published = $is_published,
					allow_comments = $allow_comments
					WHERE post_id = $post_id
					LIMIT 1";
		$result_update = $db->query($query_update);
		if( $db->affected_rows == 1 ){
			$feedback = 'Changes successfully saved.';
		}else{
			$feedback = 'No Changes were made to this post';
		}
	}else{
		$feedback = 'There are problems with the form, Please fix:';
	}//end if valid
}//end if did_edit

//no close php