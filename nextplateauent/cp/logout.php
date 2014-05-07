<?php
//If the user is logged in, delete the cookie to log them out
if(isset($_COOKIE['u_id'])) {
	//log action in database
	$u_id = $_COOKIE['u_id'];
	include_once('php/conn.php');
	$text = "INSERT INTO logs (user_id, user_action, time_stamp) VALUES ($u_id, 'user logout', (NOW() + INTERVAL 3 HOUR))";
	$query = mysqli_query($dbc, $text)
		or die('Error updating log');
	mysqli_close($dbc);
	setcookie('u_id', '', time() - 3600);
	setcookie('username', '', time() - 3600);
}
//Redirect to home page
header('Location: index.php');
?>