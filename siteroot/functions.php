<?php
/*
Convert any Datetime into a human readable format
 */
function convert_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('l, F j, Y');
}

/*
Convert any Datetime into a human readable format
 */
function rss_date( $timestamp ){
	$date = new DateTime( $timestamp );
	return $date->format('r');
}

/*
Count the number of comments on any post
$post_id - int. any valid post ID. 
$one - string. text to show if there's one comment
$many - string. text to show if there's many or zero comments
 */
function count_comments( $post_id, $one = ' comment' , $many = ' comments' ){
	//the database connection was defined out in the global scope. go get it. 
	global $db;
	//query
	$query = "SELECT COUNT(*) AS total
				FROM comments
				WHERE post_id = $post_id";
	//run it
	$result = $db->query($query);
	//check it
	if( $result->num_rows >= 1){
		//loop it
		while( $row = $result->fetch_assoc() ){
			//display the count with correct grammar
			if( $row['total'] == 1 ){
				echo $row['total'] . $one;
			}else{
				echo $row['total'] . $many;
			}
			
		}
	}
	
}

/*
Helper function to clean string data before sending it to the DB
 */
function clean_string( $dirty ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $dirty, FILTER_SANITIZE_STRING ));
}

function clean_email( $dirty ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $dirty, FILTER_SANITIZE_EMAIL ));
}

function clean_int( $dirty ){
	global $db;
	return mysqli_real_escape_string($db, filter_var( $dirty, FILTER_SANITIZE_NUMBER_INT ));
}

function clean_boolean( $dirty ){
	global $db;
	$clean = mysqli_real_escape_string($db, filter_var( $dirty, FILTER_SANITIZE_NUMBER_INT ));
	//if the value is anything other than 1, change it to ZERO.
	if($clean != 1){
		$clean = 0;
	}
	return $clean;
}


/*
Display the HTML for success or error messages, with a list of errors if needed
 */
function show_feedback( $message, $list ){
	if( isset( $message ) ){
		$class='success';
		if(!empty( $list )){
			$class='error';
		}
		?>
		<div class="feedback <?php echo $class; ?>">
			<b><?php echo $message; ?></b>

			<?php //if the list is not empty, show it
			if( !empty( $list ) ){ ?>
			<ul>
				<?php foreach( $list as $item ){ ?>
				<li>
					<?php echo $item; ?>
				</li>
				<?php } //end foreach ?>
			</ul>
			<?php } //end if not empty ?>
		</div>
		<?php
	} //end if 
}

/*
Display a dropdown menu of all categories
$current = int.  the ID of the category that you want to mark "selected" (optional)
 */
function category_dropdown( $current = 0 ){
	global $db;
	$query = "SELECT * FROM categories";
	$result = $db->query($query);
	if( $result->num_rows >= 1 ){
	?>
	<select name="category_id" id="the_cat">
		<?php while( $row = $result->fetch_assoc() ){ ?>
		<option value="<?php echo $row['category_id']; ?>" <?php 
			if( $current == $row['category_id'] ){ 
				echo 'selected'; 
			} ?>>
			<?php echo $row['name']; ?>
		</option>
		<?php } ?>
	</select>
	<?php
	}else{
		echo 'No Categories to Show';
	}
}

/*
Display Any user's picture at any size (thumb, med or large)
*/
function show_profile_pic( $user_id, $size = 'thumb_img' ){
	global $db;
	$query = "SELECT profile_pic FROM users
			WHERE user_id = $user_id
			LIMIT 1";
	$result = $db->query($query);
	if( $result->num_rows == 1 ){
		$row = $result->fetch_assoc();
		if( $row['profile_pic'] == '' ){
			echo '<img src="http://localhost/melissa-php-0517/blog/siteroot/images/default.png" class="profile_pic default_pic">';
		}else{
			//show the image
			echo '<img src="http://localhost/melissa-php-0517/blog/siteroot/uploads/' . $row['profile_pic'] . '_' . $size . '.jpg" alt="Profile Picture" class="profile_pic">';
		}
	}
}
//no close php