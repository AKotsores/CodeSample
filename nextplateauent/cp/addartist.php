<?php
//make sure a user is logged in
if (empty($_COOKIE['username'])) {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//check if form was submitted
if(isset( $_POST['submit'] ) || isset( $_POST['submit_x']) ) {
	//connect to database
	include_once('php/conn.php');
	require_once('php/sysvars.php');
	//put results in variables
	$name = mysqli_real_escape_string($dbc, trim($_POST['Name']));
	$l1 = mysqli_real_escape_string($dbc, trim($_POST['Website']));
	$l2 = mysqli_real_escape_string($dbc, trim($_POST['Twitter']));
	$l3 = mysqli_real_escape_string($dbc, trim($_POST['Facebook']));
	$l4 = mysqli_real_escape_string($dbc, trim($_POST['Google']));
	$l5 = mysqli_real_escape_string($dbc, trim($_POST['Instagram']));
	$l6 = mysqli_real_escape_string($dbc, trim($_POST['YouTube']));
	$l7 = mysqli_real_escape_string($dbc, trim($_POST['Soundcloud']));
	$l8 = mysqli_real_escape_string($dbc, trim($_POST['Pinterest']));
	$l9 = mysqli_real_escape_string($dbc, trim($_POST['LastFM']));
	$l10 = mysqli_real_escape_string($dbc, trim($_POST['LinkedIn']));
	$l11 = mysqli_real_escape_string($dbc, trim($_POST['MySpace']));
	$profile = mysqli_real_escape_string($dbc, trim($_POST['Profile']));
	$audio = mysqli_real_escape_string($dbc, trim(str_replace('"', '&quot;', $_POST['Audio'])));
	$video = mysqli_real_escape_string($dbc, trim(str_replace('"', '&quot;', $_POST['Video'])));
	$image = str_replace(" ", "", $_FILES['Image'] ['name']);
	$featured = $_POST['Featured'];
	
	$insertTXT = $valuesTXT = '';
	//replace images
	if(!empty($image)) {
		$insertTXT .= ", photo";
		$valuesTXT .= ", '$image'";
		$target = GW_UPLOADPATH_PHOTO . $image;
		move_uploaded_file($_FILES['Image'] ['tmp_name'], $target)
			or die("Error moving flyer");
	}
		
	//insert record
	$text = "INSERT INTO artists (name, profile, audio, video, website, twitter, facebook, googleplus, instagram, youtube, soundcloud, pinterest, linkedin, lastfm, myspace $insertTXT) VALUES ('$name', '$profile', '$audio', '$video', '$l1', '$l2', '$l3', '$l4', '$l5', '$l6', '$l7', '$l8', '$l9', '$l10', '$l11' $valuesTXT)";
	mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	
	//get artist ID that was just added
	$text = "SELECT a_id FROM artists ORDER BY a_id DESC LIMIT 1";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	while ($row = mysqli_fetch_array($query)) {
		$a_id = $row['a_id'];
	}	
	if($featured==1) {
		//put in featured table
		$text = "INSERT INTO featured (artists_a_id) VALUES ($a_id)";
		mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
	}
	//record in log
	$u_id = $_COOKIE['u_id'];
	$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'artists', $a_id, 'new artist added', (NOW() + INTERVAL 3 HOUR))";
	mysqli_query($dbc, $text)
		or die('Error updating log: ' . mysqli_error($dbc));
	//close database connection
	mysqli_close($dbc);
	//refresh page
	header('Location: all.php');
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
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-artists.png" width="974" height="102"></div>
</div>
<div style="width:974px; height:1000px; margin:0px auto; padding-top:10px">
	<div style="margin-bottom:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a></div>
	<form action="addartist.php" method="post" enctype="multipart/form-data">
    <div style="width:150px; float:left; height:35px; line-height:35px">Artist Name: </div><div style="width:800px; height:35px; float:right"><input name="Name" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Default Image: </div><div style="width:800px; height:35px; float:right"><input name="Image" type="file" style="width:250px; height:25px"><font size="-2" color="#D71F30">*Default image is 643 pixels wide and 357 pixels high</font></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Featured: </div><div style="width:800px; height:35px; float:right"><input name="Featured" type="checkbox" value="1"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Website: </div><div style="width:800px; height:35px; float:right"><input name="Website" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Twitter: </div><div style="width:800px; height:35px; float:right"><input name="Twitter" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Facebook: </div><div style="width:800px; height:35px; float:right"><input name="Facebook" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Google+: </div><div style="width:800px; height:35px; float:right"><input name="Google" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Instagram: </div><div style="width:800px; height:35px; float:right"><input name="Instagram" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">YouTube: </div><div style="width:800px; height:35px; float:right"><input name="YouTube" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Soundcloud: </div><div style="width:800px; height:35px; float:right"><input name="Soundcloud" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Pinterest: </div><div style="width:800px; height:35px; float:right"><input name="Pinterest" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">LastFM: </div><div style="width:800px; height:35px; float:right"><input name="LastFM" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">LinkedIn: </div><div style="width:800px; height:35px; float:right"><input name="LinkedIn" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">MySpace: </div><div style="width:800px; height:35px; float:right"><input name="MySpace" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:305px; line-height:35px">Profile: </div><div style="width:800px; height:305px; float:right"><textarea name="Profile" style="width:500px; height:300px"></textarea></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Audio: </div><div style="width:800px; height:35px; float:right"><input name="Audio" type="text" style="width:500px; height:25px"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Video: </div><div style="width:800px; height:35px; float:right"><input name="Video" type="text" style="width:500px; height:25px"></div>
    <input name="submit" type="submit">
    </form>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>