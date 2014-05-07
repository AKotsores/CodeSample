<?php
//make sure a user is logged in
if (empty($_COOKIE['username']) || $_COOKIE['level'] != 'Admin') {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//get ID from URL
$id = $_REQUEST['id'];
$process = true;
if(empty($id)) { $process = false; }
//if ID is not empty, check if it exists in database
if($process) {
	//connect to database
	include('php/conn.php');
	//query database
	$text = "SELECT * FROM users WHERE u_id = '$id'";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//get number of results
	$num_results = mysqli_num_rows($query);
	//if results is zero, then item does not exist
	if($num_results == 0) { $process = false; }
	//if item exists, run query to delete
	if($process) {
		//delete log records for user
		$text = "DELETE FROM logs WHERE user_id = '$id'";
		mysqli_query($dbc, $text)
			or die("Error removing logs: " . mysqli_error($dbc));
		//delete user from users
		$text = "DELETE FROM users WHERE u_id = '$id'";
		mysqli_query($dbc, $text)
			or die("Error deleting record: " . mysqli_error($dbc));
		//record in log
		$u_id = $_COOKIE['u_id'];
		$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'users', $id, 'user deleted', (NOW() + INTERVAL 3 HOUR))";
		mysqli_query($dbc, $text)
			or die('Error updating log: ' . mysqli_error($dbc));
	}
	mysqli_close($dbc);
}
//redirect back to profile
header("Location: users.php");
exit;
?>