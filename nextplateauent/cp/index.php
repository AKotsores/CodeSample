<?php
$status = '';
//Check if a user is logged in
if (!empty($_COOKIE['username'])) {
	header("Location: home.php");
	exit;
}
//Check if login was submitted
else if (isset( $_POST['Submit'] ) || isset( $_POST['Submit_x'] )) {
	//connect to database
	include('php/conn.php');
	//put inputed values into variables
	$un = mysqli_real_escape_string($dbc, trim($_POST['Username']));
	$pw = mysqli_real_escape_string($dbc, trim($_POST['Password']));
	//Check that both fields are filled in
	if(!empty($un) && !empty($pw)) {
		//Verify un & pw against users table
		$text = "SELECT u_id, username, level FROM users WHERE username = '$un' AND password = SHA('$pw')";
		$query = mysqli_query($dbc, $text)
			or die('Error querying users table');
		//If verification passed
		if(mysqli_num_rows($query) == 1) {
			$output_login = false;
			$row = mysqli_fetch_array($query);
			$u_id = $row['u_id'];
			setcookie('u_id', $u_id);
			setcookie('username', $row['username']);
			setcookie('level', $row['level']);
			$text = "INSERT INTO logs (user_id, user_action, time_stamp) VALUES ($u_id, 'user login', (NOW() + INTERVAL 3 HOUR))";
			$query = mysqli_query($dbc, $text)
				or die("Error updating log: " . mysqli_error($dbc));
			header("Location: home.php");
		}
		//if verification failed
		else $status = 'The username and/or password did not match.<br>';
	}
	//If both fields are not filled in
	else $status = 'You must fill in both username and password.<br>';
	//close database connection
	mysqli_close($dbc);
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau</title>
<link href='http://fonts.googleapis.com/css?family=Karla|Oswald' rel='stylesheet' type='text/css'>
<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
<?php include_once('header.php'); ?>
<div style="background-color:#D1D3D4; height:350px">
	<div style="width:974px; height:294px; margin:0 auto; padding-top:30px; padding-bottom:30px">
        <div style="width:452px; height:290px; padding-left:15px; float:left">
        	<h2>LOGIN TO CONTROL PANEL</h2>
            <form action="index.php" method="post">
            <h3>Username<br><input name="Username" type="text" value="<?php echo $un; ?>" style="width:300px; height:28px; border:#A7A9AC solid 1px; color:#939598"></h3>
            <h3>Password<br><input name="Password" type="password" style="width:300px; height:28px; border:#A7A9AC solid 1px; color:#939598"></h3>
            <input type="image" src="images/button-login.png" border="0" alt="Submit" name="Submit" onMouseOver="javascript:this.src='images/button-loginO.png';" onMouseOut="javascript:this.src='images/button-login.png';">
            <?php if(!empty($status)) echo '<font style="color:#D71F30; font-size:12px"> ' . $status . '</font>'; ?>
            </form>
        </div>
        <div style="width:443px; height:290px; padding-left:15px; padding-right:15px; float:right">
        	<h4>You can log in here to create/maintain the artists, releases and publishing pages. If you are having trouble signing in, please contact the <a href="mailto:alex@subtextinc.com">website administrator</a>.</h4>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>