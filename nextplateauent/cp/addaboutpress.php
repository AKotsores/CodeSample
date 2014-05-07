<?php
//make sure a user is logged in
if (empty($_COOKIE['username'])) {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//check if form was submitted
if(isset( $_POST['submit'] ) || isset( $_POST['submit_x']) ) {
	require_once('php/conn.php');
	require_once('php/sysvars.php');
	//put results in variables
	$link = mysqli_real_escape_string($dbc, trim($_POST['URL']));
	$image = str_replace(" ", "", $_FILES['Image'] ['name']);
	$icon = str_replace(" ", "", $_FILES['Icon'] ['name']);
	
	$insertTXT = $valuesTXT = '';
	if(!empty($image)) {
		$insertTXT .= "file";
		$valuesTXT .= "'$image'";
		$target = GW_UPLOADPATH_PRESS . $image;
		move_uploaded_file($_FILES['Image'] ['tmp_name'], $target)
			or die("Error moving flyer");
	}
	if(!empty($icon)) {
		$insertTXT .= ", icon";
		$valuesTXT .= ", '$icon'";
		$target = GW_UPLOADPATH_PRESS . $icon;
		move_uploaded_file($_FILES['Icon'] ['tmp_name'], $target)
			or die("Error moving flyer");
	}
	if(!empty($link)) {
		$insertTXT .= ", url";
		$valuesTXT .= ", '$link'";
	}
		
	//insert record
	$text = "INSERT INTO aboutpress ($insertTXT) VALUES ($valuesTXT)";
	mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//record in log
	$u_id = $_COOKIE['u_id'];
	$text = "INSERT INTO logs (user_id, npe_table, user_action, time_stamp) VALUES ($u_id, 'NPE Press', 'press record added', (NOW() + INTERVAL 3 HOUR))";
	mysqli_query($dbc, $text)
		or die('Error updating log: ' . mysqli_error($dbc));
	//close database connection
	mysqli_close($dbc);
	//refresh page
	header('Location: about.php');
}
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
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-about.png" width="974" height="102"></div>
</div>
<div style="width:974px; height:400px; margin:0px auto; padding-top:10px">
	<div style="margin-bottom:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a></div>
	<div style="width:974px">
	<form action="addaboutpress.php" method="post" enctype="multipart/form-data">
    <div style="width:200px; height:30px; float:left; margin-right:15px; line-height:30px">Press Icon:</div><div style="width:759px; height:30px; float:left; line-height:30px"><input name="Icon" type="file"><font size="-2" color="#D71F30">*Default image is 150 pixels wide and 150 pixels high</font></div>
    <div style="width:200px; height:30px; float:left; margin-right:15px; line-height:30px">Press File:</div><div style="width:759px; height:30px; float:left; line-height:30px"><input name="Image" type="file"></div>
    <div style="width:974px; float:left; height:20px; line-height:20px">- OR -</div>
    <div style="width:200px; height:30px; float:left; margin-right:15px; margin-bottom:15px; line-height:30px">Press Link:</div><div style="width:759px; height:30px; float:left; line-height:30px; margin-bottom:15px"><input name="URL" type="text" maxlength="150" style="width:500px; height:28px"></div>
    <input name="submit" type="submit">
    </form>
    </div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>