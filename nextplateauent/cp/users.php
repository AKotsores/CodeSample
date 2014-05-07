<?php
//make sure a user is logged in
if (empty($_COOKIE['username']) || $_COOKIE['level'] != 'Admin') {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//connect to database
include('php/conn.php');
//get user details
$text = "SELECT u_id, username, email FROM users WHERE username!='" . $_COOKIE['username'] . "'";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
while ($row = mysqli_fetch_array($query)) {
	$id[] = $row['u_id'];
	$username[] = stripslashes($row['username']);
	$email[] = stripslashes($row['email']);
}
//get number of rows
$total_num_results = mysqli_num_rows($query);
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

function verify()
{
	return confirm('Do you really want to delete this user?')
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png','../images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="images/subhead-users.png" width="974" height="102"></div>
</div>
<div style="width:974px; height:400px; margin:0px auto; padding-top:10px">
	<div style="margin-bottom:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a><br><a href="adduser.php"><img src="images/button-addusers.png" border="0" style="margin-top:15px"></a></div>
	<div style="width:974px; height:30px">
		<div style="font-size:14px; font-weight:bold">
		  <div style="width:200px; float:left">Username</div>
          <div style="width:250px; float:left">Email</div>
	  </div>
    </div>
    <?php $n=1; for($i=0; $i<$total_num_results; $i++) { ?>
    <div style="width:550px; height:25px; font-size:14px; line-height:25px<?php if($n%2 != 0) echo "; background-color:#dcdddf"; ?>">
      <div style="width:196px; float:left; padding-left:4px"><?php echo $username[$i]; ?></div>
      <div style="width:246px; float:left; padding-left:4px"><?php echo $email[$i]; ?></div>
      <div style="float:right"><a href="edituser.php?id=<?php echo $id[$i]; ?>"><img src="images/button-pencil.png" border="0"></a> <a href="deleteuser.php?id=<?php echo $id[$i]; ?>" onClick="return verify()"><img src="images/button-x.png" border="0"></a></div>
	</div>
    <?php $n++; } ?>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>