<?php 
//image upload parser
if( $_POST['did_upload'] ){
	// echo '<pre>';
	// 	print_r($_FILES);
	// echo '</pre>';
	
	//file uploading stuff begins	
	$target_path = "../uploads/";
	
	//list of image sizes to generate. 
	$sizes = array(
		'thumb_img' => 150,
		'medium_img' => 300,
		'large_img' => 600
		);	

	// This is the temporary file created by PHP
	$uploadedfile = $_FILES['uploadedfile']['tmp_name'];
	// Capture the original size of the uploaded image
	list($width,$height) = getimagesize($uploadedfile);
	
	//make sure the width and height exist, otherwise, this is not a valid image
	if($width > 0 AND $height > 0){

	//what kind of image is it
		$filetype = $_FILES['uploadedfile']['type'];

		switch($filetype){
			case 'image/gif':
			// Create an Image from it so we can do the resize
			$src = imagecreatefromgif($uploadedfile);
			break;

			case 'image/pjpeg':
			case 'image/jpg':
			case 'image/jpeg': 
			// Create an Image from it so we can do the resize
			$src = imagecreatefromjpeg($uploadedfile);
			break;

			case 'image/png':
			// Create an Image from it so we can do the resize
			$required_memory = Round($width * $height * $size['bits']);
			$new_limit=memory_get_usage() + $required_memory;
			ini_set("memory_limit", $new_limit);
			$src = imagecreatefrompng($uploadedfile);
			ini_restore ("memory_limit");
			break;

			
		}
	//for filename
		$randomsha = sha1(microtime());

	//do it!  resize images
		foreach($sizes as $size_name => $size_width){
			if($width >=  $size_width){
				$newwidth = $size_width;
				$newheight=($height/$width) * $newwidth;
			}else{
				$newwidth=$width;
				$newheight=$height;
			}
			$tmp = imagecreatetruecolor($newwidth,$newheight);
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);

			$filename = $target_path.$randomsha.'_'.$size_name.'.jpg';
			$didcreate = imagejpeg($tmp,$filename,70);
			imagedestroy($tmp);

		}

		imagedestroy($src);

		//if it successfully saved the file, add the filename to the DB
		if($didcreate){
			$user_id = $logged_in_user['user_id'];
			
			//DELETE OLD FILE
			//look up the old image name
			$query_oldfile = "SELECT profile_pic FROM users where user_id = $user_id LIMIT 1";
			$result_oldfile = $db->query($query_oldfile);
			if($result_oldfile->num_rows == 1){
				$row_oldfile = $result_oldfile->fetch_assoc();
				foreach ($sizes as $size_name => $size_width) {
               		 //get filepath of old file
					echo $old_file = '../uploads/'.$row_oldfile['profile_pic'].'_'.$size_name.'.jpg';
                 //Delete the file from the directory with unlink()
					@unlink($old_file);
				}
			}
			//END DELETE OLD FILE
			
			$query = "UPDATE users
			SET profile_pic = '$randomsha'
			WHERE user_id = $user_id
			LIMIT 1";
			$result = $db->query($query);
			//check to see if there was a problem
			if($db->affected_rows != 1){
				$didcreate = false;
			}
		}

		
	}else{//width and height not greater than 0
		$didcreate = false;
	}
	
	
	if($didcreate) {
		$statusmsg .=  "The file ".  basename( $_FILES['uploadedfile']['name']). 
		" has been uploaded <br />";
	} else{
		$statusmsg .= "There was an error uploading the file, please try again!<br />";
	}		
} //end image parser
//no close php
