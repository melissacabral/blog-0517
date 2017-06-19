<?php
if( $_POST['did_post'] ){
	//clean all fields
	$title 			= clean_string($_POST['title']);
	$body 			= clean_string($_POST['body']);
	$category_id 	= clean_int($_POST['category_id']);
	$is_published 	= clean_boolean($_POST['is_published']);
	$allow_comments = clean_boolean($_POST['allow_comments']);

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
		if($category_id == ''){
			$valid = false;
			$errors['category_id'] = 'The category cannot be blank.';
		}
		
		
	//if it's all valid, add this post to the DB
	if($valid){
		$user_id = $logged_in_user['user_id'];
		$query = "INSERT INTO posts
					(title, body, date, category_id, user_id, allow_comments, is_published)
					VALUES
					('$title', '$body', now(), $category_id, $user_id, 
					$allow_comments, $is_published )";
		$result = $db->query($query);
		if( $db->affected_rows == 1 ){
			$feedback = 'Success! Your post has been saved.';
		}else{
			$feedback = 'There was a problem with the query.';
		}
	}//end if valid
	else{
		$feedback = 'There are problems with the form. Fix them:';
	}
}//end of write-parse
//no close php