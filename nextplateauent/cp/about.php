<?php
//make sure a user is logged in
if (empty($_COOKIE['username'])) {
	//redirect to login page
	header("Location: index.php");
	exit;
}
if(isset( $_POST['history'] ) || isset( $_POST['history_x']) ) {
	//connect to database
	include_once('php/conn.php');
	//put results in variables
	$audio = mysqli_real_escape_string($dbc, trim(str_replace('"', '&quot;', $_POST['Audio'])));
	$video = mysqli_real_escape_string($dbc, trim(str_replace('"', '&quot;', $_POST['Video'])));
	$history = mysqli_real_escape_string($dbc, trim($_POST['History']));
	$founder = mysqli_real_escape_string($dbc, trim($_POST['Founder']));
	//update record
	$text = "UPDATE about SET audio='$audio', video='$video', history='$history', founder='$founder' WHERE id=1";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//record in log
	$u_id = $_COOKIE['u_id'];
	$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'about', 1, 'about page updated', (NOW() + INTERVAL 3 HOUR))";
	mysqli_query($dbc, $text)
		or die('Error updating log: ' . mysqli_error($dbc));
	//close database connection
	mysqli_close($dbc);
	//refresh
	header('Location: about.php');
}
//connect to database
include_once('php/conn.php');
//query audio and video
$text = "SELECT * FROM about";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$audio = stripslashes($row['audio']);
	$video = stripslashes($row['video']);
	$history = stripslashes($row['history']);
	$founder = stripslashes($row['founder']);
}
//get press for NPE
$text = "SELECT p_id, icon, file, url FROM aboutpress";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of press items
$press_num_rows = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$p_id[] = $row['p_id'];
	$icon[] = stripslashes($row['icon']);
	$file[] = stripslashes($row['file']);
	$url[] = stripslashes($row['url']);
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

function verify2()
{
	return confirm('Are you sure you want to delete this press item?')
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-about.png" width="974" height="102"></div>
</div>
<div style="width:974px; margin:0px auto">
	<form action="about.php" method="post">
	<div style="margin-top:20px"><input type="image" src="images/button-update.png" border="0" alt="Submit" name="history"></div>
	<div style="padding-top:25px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B">HISTORY</div>
    <div style="padding-top:33px; line-height:18px; font-size:14px">
    	<div style="float:left; width:480px; margin-bottom:8px; color:#D71F30"><input name="Audio" type="text" style="width:480px; height:20px" value="<?php echo $audio; ?>" maxlength="500"><br>
    	*Make sure height is set to 360</div>
    	<div style="float:right; width:480px; margin-bottom:8px; color:#D71F30"><input name="Video" type="text" style="width:480px; height:20px" value="<?php echo $video; ?>" maxlength="500"><br>
    	*Make sure width is set to 480 and height is set to 360</div>
    	<div style="float:left; width:480px; height:360px; padding-bottom:10px"><?php echo str_replace('&quot;', '"', $audio); ?></div>
    	<div style="float:right; width:480px; height:360px; padding-bottom:10px"><?php echo str_replace('&quot;', '"', $video); ?></div>
    	<textarea name="History" style="width:975px; height:600px; background:none; border:none; font-family:'Karla', sans-serif; color:#808285; font-size:14px"><?php echo $history; ?></textarea>
    </div>
	<div style="padding-top:57px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B">FOUNDER</div>
    <div style="padding-top:33px; line-height:18px; font-size:14px">
    	<img src="../images/eddie.jpg" align="left" style="margin-right:10px">
    	<textarea name="Founder" style="width:800px; height:300px; background:none; border:none; font-family:'Karla', sans-serif; color:#808285; font-size:14px"><?php echo $founder; ?></textarea>
	</div>
	</form>
    <div style="padding-top:57px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B">PRESS <a href="addaboutpress.php"><img src="images/button-add-press.png" alt="" border="0"></a></div>
    <div style="padding-top:33px; width:974px; height:150px">
		<?php for($i=0; $i<$press_num_rows; $i++) { ?>
        <a href="<?php if(!empty($url[$i])) echo $url[$i]; else echo "../press/" . $file[$i]; ?>" target="_blank"><div style="height:150px; width:150px; background-image:url(../images/pressBG.jpg); margin-right:16px; float:left" onMouseOver="<?php echo $p_id[$i]; ?>.style.width='98px'; <?php echo $p_id[$i]; ?>.style.height='98px'; <?php echo $p_id[$i]; ?>.style.padding='12px'" onMouseOut="<?php echo $p_id[$i]; ?>.style.width='150px'; <?php echo $p_id[$i]; ?>.style.height='150px'; <?php echo $p_id[$i]; ?>.style.padding='0px'"><img id="<?php echo $p_id[$i]; ?>" src="../press/<?php echo $icon[$i]; ?>" style="border:#D71F30 solid 1px; width:150px; height:150px"><br><a href="editaboutpress.php?id=<?php echo $p_id[$i]; ?>"><img src="images/button-edit.png"></a> <a href="deleteaboutpress.php?id=<?php echo $p_id[$i]; ?>" onClick="return verify2()"><img src="images/button-delete.png" border="0"></a></div></a>
    	<?php } ?>
	</div>
    <div style="padding-top:57px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B">ONLINE</div>
    <div style="padding-top:33px; padding-bottom:30px"><a href="http://www.twitter.com/NextPlateauEnt" target="_blank"><img src="../images/icon-twitter.png" alt="Twitter" border="0" onMouseOver="this.src='../images/icon-twitterO.png'" onMouseOut="this.src='../images/icon-twitter.png'"></a><a href="http://www.facebook.com/pages/Next-Plateau-Entertainment-Inc/137396359614566" target="_blank"><img src="../images/icon-fb.png" alt="Facebook" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-fbO.png'" onMouseOut="this.src='../images/icon-fb.png'"></a><a href="https://plus.google.com/u/0/b/111442069396927984097/111442069396927984097/posts" target="_blank"><img src="../images/icon-google.png" alt="Google+" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-googleO.png'" onMouseOut="this.src='../images/icon-google.png'"></a><a href="http://www.instagram.com/NextPlateauEntertainment" target="_blank"><img src="../images/icon-instagram.png" alt="Instagram" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-instagramO.png'" onMouseOut="this.src='../images/icon-instagram.png'"></a><a href="http://www.youtube.com/user/NextPlateauEnt?feature=mhee" target="_blank"><img src="../images/icon-youtube.png" alt="YouTube" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-youtubeO.png'" onMouseOut="this.src='../images/icon-youtube.png'"></a><a href="http://www.soundcloud.com/nextplateauinc" target="_blank"><img src="../images/icon-soundcloud.png" alt="Sound Cloud" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-soundcloudO.png'" onMouseOut="this.src='../images/icon-soundcloud.png'"></a><a href="http://www.pinterest.com/nextplateau/" target="_blank"><img src="../images/icon-pinterest.png" alt="Pinterest" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-pinterestO.png'" onMouseOut="this.src='../images/icon-pinterest.png'"></a><a href="http://www.last.fm/user/NextPlateauEnt" target="_blank"><img src="../images/icon-lastfm.png" alt="Last FM" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-lastfmO.png'" onMouseOut="this.src='../images/icon-lastfm.png'"></a><a href="http://www.linkedin.com/company/2758025?trk=tyah" target="_blank"><img src="../images/icon-linkedin.png" alt="LinkedIn" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-linkedinO.png'" onMouseOut="this.src='../images/icon-linkedin.png'"></a><a href="http://www.myspace.com/nextplateauent" target="_blank"><img src="../images/icon-myspace.png" alt="MySpace" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-myspaceO.png'" onMouseOut="this.src='../images/icon-myspace.png'"></a></div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>