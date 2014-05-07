<?php
//make sure a user is logged in
if (empty($_COOKIE['username'])) {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//get id from url
$id = $_REQUEST['id'];
//make sure id is not null and a number
if(!empty($id) && is_numeric($id)) {
	//connect to database
	include_once('php/conn.php');
	//check if form was submitted
	if(isset( $_POST['submit'] ) || isset( $_POST['submit_x']) ) {
		require_once('php/sysvars.php');
		//put results in variables
		$a1 = mysqli_real_escape_string($dbc, trim($_POST['a1']));
		$a2 = mysqli_real_escape_string($dbc, trim($_POST['a2']));
		$t1 = mysqli_real_escape_string($dbc, trim($_POST['t1']));
		$t2 = mysqli_real_escape_string($dbc, trim($_POST['t2']));
		$released = mysqli_real_escape_string($dbc, trim($_POST['date']));
		$itunes = mysqli_real_escape_string($dbc, trim($_POST['iTunes']));
		$amazon = mysqli_real_escape_string($dbc, trim($_POST['Amazon']));
		$beatport = mysqli_real_escape_string($dbc, trim($_POST['Beatport']));
		$emusic = mysqli_real_escape_string($dbc, trim($_POST['eMusic']));
		$spotify = mysqli_real_escape_string($dbc, trim($_POST['Spotify']));
		$rhapsody = mysqli_real_escape_string($dbc, trim($_POST['Rhapsody']));
		$deezer = mysqli_real_escape_string($dbc, trim($_POST['Deezer']));
		$simfy = mysqli_real_escape_string($dbc, trim($_POST['Simfy']));
		$google = mysqli_real_escape_string($dbc, trim($_POST['GooglePlay']));
		$iheart = mysqli_real_escape_string($dbc, trim($_POST['iHeartRadio']));
		$muve = mysqli_real_escape_string($dbc, trim($_POST['MuveMusic']));
		$pandora = mysqli_real_escape_string($dbc, trim($_POST['Pandora']));
		$touch = mysqli_real_escape_string($dbc, trim($_POST['TouchTunes']));
		$myxer = mysqli_real_escape_string($dbc, trim($_POST['Myxer']));
		$image = str_replace(" ", "", $_FILES['cover'] ['name']);
		$featured = $_POST['Featured'];
		
		$insertTXT = $valuesTXT = '';
		//replace images
		if(!empty($image)) {
			$insertTXT .= ", cover='$image'";
			$target = GW_UPLOADPATH_COVER . $image;
			move_uploaded_file($_FILES['cover'] ['tmp_name'], $target)
				or die("Error moving cover");
		}
		if($featured==1) {
			$insertTXT .= ", featured='$featured'";
		}
		else
			$insertTXT .= ", featured=0";
			
		//insert record
		$text = "UPDATE singles SET artist1='$a1', artist2='$a2', title1='$t1', title2='$t2', released='$released', iTunes='$itunes', Amazon='$amazon', Beatport='$beatport', eMusic='$emusic', Spotify='$spotify', Rhapsody='$rhapsody', Deezer='$deezer', Simfy='$simfy', GooglePlay='$google', iHeartRadio='$iheart', MuveMusic='$muve', Pandora='$pandora', TouchTunes='$touch', Myxer='$myxer' $insertTXT WHERE s_id=$id";
		$query = mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
		//record in log
		$u_id = $_COOKIE['u_id'];
		$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'singles', $id, 'release record updated', (NOW() + INTERVAL 3 HOUR))";
		mysqli_query($dbc, $text)
			or die('Error updating log: ' . mysqli_error($dbc));
		//close database connection
		mysqli_close($dbc);
		//refresh page
		header('Location: profile.php?id=' . $a1);
	}
	$text = "SELECT * FROM singles WHERE s_id=$id";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	while($row = mysqli_fetch_array($query)) {
		$s_id = $row['s_id'];
		$a1 = $row['artist1'];
		$a2 = stripslashes($row['artist2']);
		$t1 = stripslashes($row['title1']);
		$t2 = stripslashes($row['title2']);
		$released = $row['released'];
		$cover = stripslashes($row['cover']);
		$featured = $row['featured'];
		$iTunes = stripslashes($row['iTunes']);
		$Amazon = stripslashes($row['Amazon']);
		$Beatport = stripslashes($row['Beatport']);
		$eMusic = stripslashes($row['eMusic']);
		$Spotify = stripslashes($row['Spotify']);
		$Rhapsody = stripslashes($row['Rhapsody']);
		$Deezer = stripslashes($row['Deezer']);
		$Simfy = stripslashes($row['Simfy']);
		$GooglePlay = stripslashes($row['GooglePlay']);
		$iHeartRadio = stripslashes($row['iHeartRadio']);
		$MuveMusic = stripslashes($row['MuveMusic']);
		$Pandora = stripslashes($row['Pandora']);
		$TouchTunes = stripslashes($row['TouchTunes']);
		$Myxer = stripslashes($row['Myxer']);
	}
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
<div style="width:974px; height:1050px; margin:0px auto; padding-top:10px">
	<div style="margin-bottom:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a></div>
	<form action="editsingle.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
    <div style="width:150px; float:left; height:35px; line-height:35px">Artist 1: </div><div style="width:800px; height:35px; float:right"><?php include_once('php/artistmenu.php'); ?></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Artist 2: </div><div style="width:800px; height:35px; float:right"><input name="a2" type="text" style="width:500px; height:25px" value="<?php echo $a2; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Title 1: </div><div style="width:800px; height:35px; float:right"><input name="t1" type="text" style="width:500px; height:25px" value="<?php echo $t1; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Title 2: </div><div style="width:800px; height:35px; float:right"><input name="t2" type="text" style="width:500px; height:25px" value="<?php echo $t2; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Release Date: </div><div style="width:800px; height:35px; float:right"><input name="date" type="text" style="width:500px; height:25px" value="<?php echo $released; ?>"></div>
    <div style="width:150px; float:left; height:200px; line-height:35px">Current Cover: </div><div style="width:800px; height:200px; float:right"><img src="../covers/<?php echo $cover; ?>" width="200" height="200"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Update Cover: </div><div style="width:800px; height:35px; float:right"><input name="cover" type="file" style="width:250px; height:25px"><font size="-2" color="#D71F30">*Cover image is 262 pixels wide and 262 pixels high</font></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Featured: </div><div style="width:800px; height:35px; float:right"><input name="Featured" type="checkbox" value="1" <?php if($featured==1) echo " checked"; ?>></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">iTunes: </div><div style="width:800px; height:35px; float:right"><input name="iTunes" type="text" style="width:500px; height:25px" value="<?php echo $iTunes; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Amazon: </div><div style="width:800px; height:35px; float:right"><input name="Amazon" type="text" style="width:500px; height:25px" value="<?php echo $Amazon; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Beatport: </div><div style="width:800px; height:35px; float:right"><input name="Beatport" type="text" style="width:500px; height:25px" value="<?php echo $Beatport; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">eMusic: </div><div style="width:800px; height:35px; float:right"><input name="eMusic" type="text" style="width:500px; height:25px" value="<?php echo $eMusic; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Spotify: </div><div style="width:800px; height:35px; float:right"><input name="Spotify" type="text" style="width:500px; height:25px" value="<?php echo $Spotify; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Rhapsody: </div><div style="width:800px; height:35px; float:right"><input name="Rhapsody" type="text" style="width:500px; height:25px" value="<?php echo $Rhapsody; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Deezer: </div><div style="width:800px; height:35px; float:right"><input name="Deezer" type="text" style="width:500px; height:25px" value="<?php echo $Deezer; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Simfy: </div><div style="width:800px; height:35px; float:right"><input name="Simfy" type="text" style="width:500px; height:25px" value="<?php echo $Simfy; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Google Play: </div><div style="width:800px; height:35px; float:right"><input name="GooglePlay" type="text" style="width:500px; height:25px" value="<?php echo $GooglePlay; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">iHeart Radio: </div><div style="width:800px; height:35px; float:right"><input name="iHeartRadio" type="text" style="width:500px; height:25px" value="<?php echo $iHeartRadio; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Muve Music: </div><div style="width:800px; height:35px; float:right"><input name="MuveMusic" type="text" style="width:500px; height:25px" value="<?php echo $MuveMusic; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Pandora: </div><div style="width:800px; height:35px; float:right"><input name="Pandora" type="text" style="width:500px; height:25px" value="<?php echo $Pandora; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Touch Tunes: </div><div style="width:800px; height:35px; float:right"><input name="TouchTunes" type="text" style="width:500px; height:25px" value="<?php echo $TouchTunes; ?>"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Myxer: </div><div style="width:800px; height:35px; float:right"><input name="Myxer" type="text" style="width:500px; height:25px" value="<?php echo $Myxer; ?>"></div>
    <input name="submit" type="submit">
    </form>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>