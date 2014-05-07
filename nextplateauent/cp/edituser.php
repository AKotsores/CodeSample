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
//check if form was submitted
if(isset( $_POST['submit'] ) || isset( $_POST['submit_x']) ) {
	$status = "";
	$continue = false;
	//connect to database
	include('php/conn.php');
	//put results in variables
	$email = mysqli_real_escape_string($dbc, trim($_POST['Email']));
	$npw = mysqli_real_escape_string($dbc, $_POST['Npw']);
	$npw2 = mysqli_real_escape_string($dbc, $_POST['Npw2']);
	$body = "Your password has been reset by Next Plateau Entertainment. You can log into your account by visiting http://www.nextplateauent.com/cp/. Your new password is " . $npw . ". If you have any questions you can contact the website administrator at admin@nextplateauent.com.";
	//make sure email address is valid
	include('php/emailVal.php');
	if(empty($status)) $continue = true;
	//if any password field is filled in make sure the rest are
	if((!empty($npw) || !empty($npw2)) && empty($status)) {
		//make sure new passwords match and is at least 8 characters with one numeric character
		if($npw == $npw2) {
			$continue = true;
			if(strlen($npw) > 8 && strcspn($npw, '0123456789') != strlen($npw)) {
				$continue = true;
				$text = "UPDATE users SET password=SHA('$npw') WHERE u_id='$id'";
				$query = mysqli_query($dbc, $text)
					or die("Error executing query: " . mysqli_error($dbc));
			}
			else {
				$status = "Your new password must contain a number and be at lest 8 characters long.";
				$continue = false;
			}
		}
		else {
			$status = "The new passwords entered did not match.";
			$continue = false;
		}
	}
	if($continue) {
		//update record
		$text = "UPDATE users SET email='$email' WHERE u_id='$id'";
		mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
		//close database connection
		mysqli_close($dbc);
		//email user
		$header = "Reply-To: Next Plateau Entertainment <info@nextplateauent.com>\r\n";
		$header .= "Return-Path: Next Plateau <info@nextplateauent.com>\r\n";
		$header .= "From: Next Plateau <info@nextplateauent.com>\r\n";
		$header .= "Organization: Next Plateau Entertainment\r\n";
		$header .= "Content-Type: text/plain\r\n";
		$header .= "X-Mailer: PHP/" . phpversion();
		$subject = "Password reset on nextplateauent.com";
		//send to new user
		mail($email, $subject, $body, $header);

		//refresh page
		header('Location: users.php');
	}
	//close database connection
	mysqli_close($dbc);
}
//if ID is not empty, check if it exists in database
if($process) {
	//connect to database
	include('php/conn.php');
	//query database
	$text = "SELECT username, email FROM users WHERE u_id = '$id'";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//get number of results
	$num_results = mysqli_num_rows($query);
	//if results is zero, then item does not exist
	if($num_results == 0) { $process = false; }
	//if item exists, run query to delete
	if($process) {
		while($row = mysqli_fetch_array($query)) {
			$email = stripslashes($row['email']);
			$username = stripslashes($row['username']);
		}
	}
}
//close database connection
mysqli_close($dbc);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau</title>
<link href='http://fonts.googleapis.com/css?family=Karla|Oswald' rel='stylesheet' type='text/css'>
<link href="../style.css" rel="stylesheet" type="text/css">
<script type="text/javascript">
function MM_swapImgRestore() { //v3.0
  var i,x,a=document.MM_sr; for(i=0;a&&i<a.length&&(x=a[i])&&x.oSrc;i++) x.src=x.oSrc;
}
function MM_preloadImages() { //v3.0
  var d=document; if(d.images){ if(!d.MM_p) d.MM_p=new Array();
    var i,j=d.MM_p.length,a=MM_preloadImages.arguments; for(i=0; i<a.length; i++)
    if (a[i].indexOf("#")!=0){ d.MM_p[j]=new Image; d.MM_p[j++].src=a[i];}}
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function MM_swapImage() { //v3.0
  var i,j=0,x,a=MM_swapImage.arguments; document.MM_sr=new Array; for(i=0;i<(a.length-2);i+=3)
   if ((x=MM_findObj(a[i]))!=null){document.MM_sr[j++]=x; if(!x.oSrc) x.oSrc=x.src; x.src=a[i+2];}
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png','../images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="images/subhead-users.png" width="974" height="102"></div>
</div>
<div style="width:974px; height:400px; margin:0px auto; padding-top:10px">
	<div style="margin-bottom:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a></div>
	<div style="width:974px">
        <form action="edituser.php?id=<?php echo $id; ?>" method="post">
        <div style="width:200px; height:30px; float:left; margin-right:15px; line-height:30px">Username:</div><div style="width:759px; height:30px; float:left; line-height:30px"><?php echo $username; ?></div>
        <div style="width:974px; float:left; height:10px"></div>
        <div style="width:200px; height:30px; float:left; margin-right:15px; margin-bottom:15px; line-height:30px">Email Address:</div><div style="width:759px; height:30px; float:left; line-height:30px; margin-bottom:15px"><span style="width:759px; height:30px; float:left; line-height:30px; margin-bottom:15px">
        <input name="Email" type="text" id="Email" style="width:200px; height:28px" value="<?php echo $email; ?>" maxlength="75">
        </span></div>
        <div style="width:200px; height:30px; float:left; margin-right:15px; margin-bottom:15px; line-height:30px">New Password:</div>
        <div style="width:759px; height:30px; float:left; line-height:30px; margin-bottom:15px"><input name="Npw" type="password" id="Npw" style="width:200px; height:28px" maxlength="75">
          <font size="-2" color="#D71F30">*Password must be at least 8 characters long and contain at least one number.</font></div>
        <div style="width:200px; height:30px; float:left; margin-right:15px; margin-bottom:15px; line-height:30px">New  Password (Again):</div>
        <div style="width:759px; height:30px; float:left; line-height:30px; margin-bottom:15px"><input name="Npw2" type="password" id="Npw2" style="width:200px; height:28px" maxlength="75"></div>
        <input name="submit" type="submit"><?php if(!empty($status)) echo " <font size='-2' color='#D71F30'>*" . $status . "</font>"; ?>
        </form>
	</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>