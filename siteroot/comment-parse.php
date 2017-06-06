<?php 
//parse the comment if one was submitted
if( $_POST['did_comment'] ){
	//extract and sanitize  (clean_string() is in our functions file)
	$name 		= clean_string( $_POST['name'] );
	$comment 	= clean_string( $_POST['comment'] );
	$email 		= clean_email($_POST['email']);
	$post_id	= clean_int($_POST['post_id']);

	//validate
	$valid = true;

	//username could be blank or too long (100 chars)
	if( $name == '' OR strlen($name) > 100 ){
		$valid = false;
		$errors['name'] = 'Please provide your name, up to 100 characters long.';
	}

	//email is blank or not the right format
	if( ! filter_var( $email, FILTER_VALIDATE_EMAIL ) ){
		$valid = false;
		$errors['email'] ='Please provide a valid email. It will not be displayed publicly';
	}

	//comment is blank
	if( $comment == '' ){
		$valid = false;
		$errors['comment'] = 'Comment field cannot be left blank.';
	}
	
	//if valid, add to DB
	if( $valid ){
		//TODO: once the admin panel is set up, change the "is_approved" value
		$query = "INSERT INTO comments
				(name, date, email, body, post_id, is_approved)
				VALUES
				('$name', now(), '$email', '$comment', $post_id, 1 )";
		//run it
		$result = $db->query($query);
		//check it
		if( $db->affected_rows == 1 ){
			//success
			$feedback = 'Thank you for your comment, it will appear shortly.';
		}else{
			//error - DB
			$feedback = 'Sorry, Something went wrong, your comment could not be posted.';
		}
	} //end if valid
	else{
		//error - not valid submission
		$feedback = "There are errors in the comment form, Please fix the following:";
	}
	//give user feedback
} //end of comment parser