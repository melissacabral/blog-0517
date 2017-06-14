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


/*
Display the HTML for success or error messages, with a list of errors if needed
 */
function show_feedback( $message, $list ){
	if( isset( $message ) ){
		?>
		<div class="feedback">
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
//no close php