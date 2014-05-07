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
	if(isset( $_POST['content'] ) || isset( $_POST['content_x']) ) {
		//put results in variables
		require_once('php/sysvars.php');
		$artist = mysqli_real_escape_string($dbc, trim($_POST['Artist']));
		$image = str_replace(" ", "", $_FILES['Image'] ['name']);
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
		
		$insertTXT = '';
		//replace images
		if(!empty($image)) {
			$insertTXT .= ", photo=";
			$insertTXT .= "'$image'";
			$target = GW_UPLOADPATH_PHOTO . $image;
			move_uploaded_file($_FILES['Image'] ['tmp_name'], $target)
				or die("Error moving flyer");
		}
		
		//update record
		$text = "UPDATE artists SET name='$artist', profile='$profile', audio='$audio', video='$video', website='$l1', twitter='$l2', facebook='$l3', googleplus='$l4', instagram='$l5', youtube='$l6', soundcloud='$l7', pinterest='$l8', linkedin='$l10', lastfm='$l9', myspace='$l11' $insertTXT WHERE a_id='$id'";
		$query = mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
		//record in log
		$u_id = $_COOKIE['u_id'];
		$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'artists', $id, 'artist profile updated', (NOW() + INTERVAL 3 HOUR))";
		mysqli_query($dbc, $text)
			or die('Error updating log: ' . mysqli_error($dbc));
		//close database connection
		mysqli_close($dbc);
		//refresh page
		header('Location: profile.php?id=' . $id);
	}
	//query artists from id
	$text = "SELECT * FROM artists WHERE a_id=$id";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//make sure result is 1
	if(mysqli_num_rows($query)==1) {
		//put results in array
		while ($row = mysqli_fetch_array($query)) {
			$artist_id = $row['a_id'];
			$name = stripslashes($row['name']);
			$photo = stripslashes($row['photo']);
			$profile = stripslashes($row['profile']);
			$audio = stripslashes($row['audio']);
			$video = stripslashes($row['video']);
			$website = stripslashes($row['website']);
			$twitter = stripslashes($row['twitter']);
			$facebook = stripslashes($row['facebook']);
			$googleplus = stripslashes($row['googleplus']);
			$instagram = stripslashes($row['instagram']);
			$youtube = stripslashes($row['youtube']);
			$soundcloud = stripslashes($row['soundcloud']);
			$pinterest = stripslashes($row['pinterest']);
			$linkedin = stripslashes($row['linkedin']);
			$lastfm = stripslashes($row['lastfm']);
			$myspace = stripslashes($row['myspace']);
		}
	}
	else {
		mysqli_close($dbc);
		header('Location: index.php');
		exit;
	}
	//get all artists
	$text = "SELECT a_id, name FROM artists ORDER BY name";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//get number of artists
	$total_num_rows = mysqli_num_rows($query);
	//put results in array
	while ($row = mysqli_fetch_array($query)) {
		$a_id[] = $row['a_id'];
		$a_name[] = strtoupper(stripslashes($row['name']));
	}
	//get press for this artist
	$text = "SELECT p_id, icon, url FROM press WHERE artists_a_id=$id";
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
	//get releases for this artist
	$text = "SELECT cover, iTunes, Amazon, Beatport, eMusic, Spotify, Rhapsody, Deezer, Simfy, GooglePlay, iHeartRadio, MuveMusic, Pandora, TouchTunes, Myxer FROM singles WHERE artist1=$id OR artist2 LIKE '%$name%' ORDER BY released DESC";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//get number of releases
	$releases_num_rows = mysqli_num_rows($query);
	//put results in array
	while ($row = mysqli_fetch_array($query)) {
		$cover[] = stripslashes($row['cover']);
		$iTunes[] = stripslashes($row['iTunes']);
		$Amazon[] = stripslashes($row['Amazon']);
		$Beatport[] = stripslashes($row['Beatport']);
		$eMusic[] = stripslashes($row['eMusic']);
		$Spotify[] = stripslashes($row['Spotify']);
		$Rhapsody[] = stripslashes($row['Rhapsody']);
		$Deezer[] = stripslashes($row['Deezer']);
		$Simfy[] = stripslashes($row['Simfy']);
		$GooglePlay[] = stripslashes($row['GooglePlay']);
		$iHeartRadio[] = stripslashes($row['iHeartRadio']);
		$MuveMusic[] = stripslashes($row['MuveMusic']);
		$Pandora[] = stripslashes($row['Pandora']);
		$TouchTunes[] = stripslashes($row['TouchTunes']);
		$Myxer[] = stripslashes($row['Myxer']);
	}
	//close database connection
	mysqli_close($dbc);
}
else {
	header('Location: index.php');
	exit;
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
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

$(document).ready(function() {
	$('.site_quick_jump').change(function(){
		// option 1 use a JS redirect in the current window
		//window.location.href = $(this).val();
		 
		// option 2; set the 'action' of the form and submit it
		if ($(this).val() != '') {
			$('#site_quick_jump_form').attr('action', $(this).val()); //
			$('#site_quick_jump_form').attr('target', '_blank'); // new window
			$('#site_quick_jump_form').submit(); // Go!
		}
	});
});

function verify()
{
	return confirm('Are you sure you want to delete this artist? By doing this you are deleting all Press and Releases associated with this artist and this action is irreversible')
}
function verify2()
{
	return confirm('Are you sure you want to delete this press item?')
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png','../images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-artists.png" width="974" height="102"></div>
</div>
<form action="profile.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
<div style="width:974px; margin:0px auto; padding-top:5px">
<input type="image" src="images/button-update-artist.png" border="0" alt="Submit" name="content"> 
&nbsp;&nbsp;&nbsp;&nbsp;<a href="deleteartist.php?id=<?php echo $id; ?>" onClick="return verify()"><img src="images/button-delete-artist.png" border="0"></a></div>
<div style="width:974px; margin:0px auto; padding-top:28px">
	<div style="width:974px; height:60px">
    	<div style="width:623px; height:50px; float:left; background-image:url(../images/tab-artist.png); padding-top:10px; padding-left:20px; color:#fff; font-size:35px; font-family:'Oswald', sans-serif">
        <input name="Artist" type="text" value="<?php echo $name; ?>" maxlength="45" style="width:500px; height:25px">
    	</div>
        <div style="width:314px; height:60px; float:right"><img src="../images/tab-all-artists.png" width="314" height="60"></div>
    </div>
    <div style="height:20px"></div>
</div>
<div style="height:357px; background-color:#D1D3D4">
	<div style="width:974px; margin:0px auto">
        <div style="width:643px; height:357px; float:left"><img src="../artists/<?php echo $photo; ?>" width="643" height="357"></div>
    <div style="width:314px; height:357px; float:right; overflow:visible; background-image:url(../images/background.jpg)">
        	<div><a href="artists.php"><img src="../images/button-featuredartists.png" width="154" height="32" border="0" onMouseOver="this.src='../images/button-featuredartistsO.png'" onMouseOut="this.src='../images/button-featuredartists.png'"></a><a href="all.php"><img src="../images/button-allartists.png" width="154" height="32" border="0" onMouseOver="this.src='../images/button-allartistsO.png'" onMouseOut="this.src='../images/button-allartists.png'" style="margin-left:6px"></a></div>
            <?php for($i=0; $i<$total_num_rows; $i++) { ?>
<a href="profile.php?id=<?php echo $a_id[$i]; ?>"><div style="padding-top:8px; padding-bottom:8px; padding-left:25px; border-bottom:#D71F30 solid 1px; color:#808285; font-family:'Oswald', sans-serif" onMouseOver="this.style.backgroundColor='#D71F30'; this.style.color='#fff';" onMouseOut="this.style.backgroundColor='transparent'; this.style.color='#808285';"><?php echo $a_name[$i]; ?></div></a>
            <?php } ?>
        </div>
    </div>    
</div>
<div style="width:974px; margin:0px auto; min-height:<?php echo ($total_num_rows*40)+32; ?>px; height:auto">
    <div style="width:974px; margin:0px auto; height:50px">Replace default image: <input name="Image" type="file" style="height:25px"><br><font size="-2" color="#D71F30">*Default image is 643 pixels wide and 357 pixels high</font></div>
    <div style="width:974px; margin:0px auto">
        <div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px">ONLINE</div>
        <div style="width:643px; height:350px; padding-top:25px">
            <div style="height:24px"><img src="../images/icon-web.png" alt="Website" style="padding-right:10px"><input name="Website" type="text" style="width:600px; height:24px" value="<?php echo $website; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-twitter.png" alt="Twitter" style="padding-right:10px"><input name="Twitter" type="text" style="width:600px; height:24px" value="<?php echo $twitter; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-fb.png" alt="Facebook" style="padding-right:10px"><input name="Facebook" type="text" style="width:600px; height:24px" value="<?php echo $facebook; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-google.png" alt="Google Plus" style="padding-right:10px"><input name="Google" type="text" style="width:600px; height:24px" value="<?php echo $googleplus; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-instagram.png" alt="Instagram" style="padding-right:10px"><input name="Instagram" type="text" style="width:600px; height:24px" value="<?php echo $instagram; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-youtube.png" alt="YouTube" style="padding-right:10px"><input name="YouTube" type="text" style="width:600px; height:24px" value="<?php echo $youtube; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-soundcloud.png" alt="Soundcloud" style="padding-right:10px"><input name="Soundcloud" type="text" style="width:600px; height:24px" value="<?php echo $soundcloud; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-pinterest.png" alt="Pinterest" style="padding-right:10px"><input name="Pinterest" type="text" style="width:600px; height:24px" value="<?php echo $pinterest; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-lastfm.png" alt="LastFM" style="padding-right:10px"><input name="LastFM" type="text" style="width:600px; height:24px" value="<?php echo $lastfm; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-linkedin.png" alt="LinkedIn" style="padding-right:10px"><input name="LinkedIn" type="text" style="width:600px; height:24px" value="<?php echo $linkedin; ?>" maxlength="100"></div>
            <div style="height:24px; padding-top:6px"><img src="../images/icon-myspace.png" alt="MySpace" style="padding-right:10px"><input name="MySpace" type="text" style="width:600px; height:24px" value="<?php echo $myspace; ?>" maxlength="100"></div>
        </div>
        <div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px">PROFILE</div>
        <div style="width:643px; padding-top:25px; padding-bottom:30px; font-size:14px; line-height:18px">
        <textarea name="Profile" cols="" rows="" id="Profile" style="width:643px; height:500px"><?php echo $profile; ?></textarea>
        </div>
        <div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">PRESS <a href="addpress.php?id=<?php echo $id; ?>"><img src="images/button-add-press.png" border="0"></a></div>
        <div style="width:643px; height:150px; padding-bottom:30px">
            <?php for($i=0; $i<$press_num_rows; $i++) { ?>
            <a href="<?php if(!empty($url[$i])) echo $url[$i]; else echo "../press/" . $file[$i]; ?>" target="_blank"><div style="height:150px; width:150px; background-image:url(../images/pressBG.jpg); margin-right:16px; float:left" onMouseOver="<?php echo $p_id[$i]; ?>.style.width='98px'; <?php echo $p_id[$i]; ?>.style.height='98px'; <?php echo $p_id[$i]; ?>.style.padding='12px'" onMouseOut="<?php echo $p_id[$i]; ?>.style.width='150px'; <?php echo $p_id[$i]; ?>.style.height='150px'; <?php echo $p_id[$i]; ?>.style.padding='0px'"><img id="<?php echo $p_id[$i]; ?>" src="../press/<?php echo $icon[$i]; ?>" style="border:#D71F30 solid 1px; width:150px; height:150px"><br><a href="editpress.php?id=<?php echo $p_id[$i]; ?>&a_id=<?php echo $artist_id; ?>"><img src="images/button-edit.png"></a> <a href="deletepress.php?id=<?php echo $p_id[$i] . "&p_id=" . $artist_id; ?>" onClick="return verify2()"><img src="images/button-delete.png" border="0"></a></div></a>
            <?php } ?>
        </div>
        <div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">AUDIO <input name="Audio" type="text" style="width:575px; height:20px" value="<?php echo $audio; ?>" maxlength="500"></div>
        <div style="width:643px; padding-bottom:30px"><?php echo str_replace('&quot;', '"', $audio); ?></div>
        <div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">VIDEO <input name="Video" type="text" style="width:575px; height:20px" value="<?php echo $video; ?>" maxlength="500"></div>
        <div style="width:643px; padding-bottom:30px"><?php echo str_replace('&quot;', '"', $video); ?></div>
        </form>
        <?php if($releases_num_rows > 0) { ?>
        <div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">RELEASES</div>
        <div style="width:643px; height:<?php echo round($releases_num_rows/2)*385 ?>px; margin-right:331px;">
            <div style="width:643px; height:356px; margin-right:331px; margin-bottom:20px">
                <?php $n=1; for($i=0; $i<$releases_num_rows; $i++) { 
                if($n==1) { if($i>0 && $i%2==0) { ?></div><div style="width:643px; height:356px; margin-right:331px; margin-bottom:20px"><?php } ?>
                <div style="width:270px; height:316px; padding:20px; background-color:#E6E7E8; float:left">
                    <div><img src="../covers/<?php echo $cover[$i]; ?>" width="270" height="270"></div>
                    <div style="padding-top:6px; width:110px; float:left"><a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="../images/button-itunes-large.png" width="110" height="40"></a></div>
                    <div class="site_quick_jump_container" style="width:150px; padding-left:10px; padding-top:16px; float:left"><?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
                    <form id="site_quick_jump_form" method="get" action="">
                        <select class="site_quick_jump" style="width:150px; height:23px; border:none; background-color:#A7A9AC; color:#fff">
                            <option>or Download on...</option>
                            <?php if(!empty($Amazon[$i])) { ?><option value="<?php echo $Amazon[$i]; ?>">Amazon</option><?php } ?>
                            <?php if(!empty($Beatport[$i])) { ?><option value="<?php echo $Beatport[$i]; ?>">Beatport</option><?php } ?>
                            <?php if(!empty($eMusic[$i])) { ?><option value="<?php echo $eMusic[$i]; ?>">eMusic</option><?php } ?>
                            <?php if(!empty($Spotify[$i])) { ?><option value="<?php echo $Spotify[$i]; ?>">Spotify</option><?php } ?>
                            <?php if(!empty($Rhapsody[$i])) { ?><option value="<?php echo $Rhapsody[$i]; ?>">Rhapsody</option><?php } ?>
                            <?php if(!empty($Deezer[$i])) { ?><option value="<?php echo $Deezer[$i]; ?>">Deezer</option><?php } ?>
                            <?php if(!empty($Simfy[$i])) { ?><option value="<?php echo $Simfy[$i]; ?>">Simfy</option><?php } ?>
                            <?php if(!empty($GooglePlay[$i])) { ?><option value="<?php echo $GooglePlay[$i]; ?>">Google Play</option><?php } ?>
                            <?php if(!empty($iHeartRadio[$i])) { ?><option value="<?php echo $iHeartRadio[$i]; ?>">iHeart Radio</option><?php } ?>
                            <?php if(!empty($MuveMusic[$i])) { ?><option value="<?php echo $MuveMusic[$i]; ?>">Muve Music</option><?php } ?>
                            <?php if(!empty($Pandora[$i])) { ?><option value="<?php echo $Pandora[$i]; ?>">Pandora</option><?php } ?>
                            <?php if(!empty($TouchTunes[$i])) { ?><option value="<?php echo $TouchTunes[$i]; ?>">Touch Tunes</option><?php } ?>
                            <?php if(!empty($Myxer[$i])) { ?><option value="<?php echo $Myxer[$i]; ?>">Myxer</option><?php } ?>
                        </select>
                    </form>
                    <?php } ?>
                  </div>
                </div>
                <?php $n++; }
                else if($n==2) { ?>
                <div style="width:270px; height:316px; padding:20px; background-color:#E6E7E8; float:right">
                    <div><img src="../covers/<?php echo $cover[$i]; ?>" width="270" height="270"></div>
                    <div style="padding-top:6px; width:110px; float:left"><a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="../images/button-itunes-large.png" width="110" height="40"></a></div>
                    <div class="site_quick_jump_container" style="width:150px; padding-left:10px; padding-top:16px; float:left"><?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
                    <form id="site_quick_jump_form" method="get" action="">
                        <select class="site_quick_jump" style="width:150px; height:23px; border:none; background-color:#A7A9AC; color:#fff">
                            <option>or Download on...</option>
                            <?php if(!empty($Amazon[$i])) { ?><option value="<?php echo $Amazon[$i]; ?>">Amazon</option><?php } ?>
                            <?php if(!empty($Beatport[$i])) { ?><option value="<?php echo $Beatport[$i]; ?>">Beatport</option><?php } ?>
                            <?php if(!empty($eMusic[$i])) { ?><option value="<?php echo $eMusic[$i]; ?>">eMusic</option><?php } ?>
                            <?php if(!empty($Spotify[$i])) { ?><option value="<?php echo $Spotify[$i]; ?>">Spotify</option><?php } ?>
                            <?php if(!empty($Rhapsody[$i])) { ?><option value="<?php echo $Rhapsody[$i]; ?>">Rhapsody</option><?php } ?>
                            <?php if(!empty($Deezer[$i])) { ?><option value="<?php echo $Deezer[$i]; ?>">Deezer</option><?php } ?>
                            <?php if(!empty($Simfy[$i])) { ?><option value="<?php echo $Simfy[$i]; ?>">Simfy</option><?php } ?>
                            <?php if(!empty($GooglePlay[$i])) { ?><option value="<?php echo $GooglePlay[$i]; ?>">Google Play</option><?php } ?>
                            <?php if(!empty($iHeartRadio[$i])) { ?><option value="<?php echo $iHeartRadio[$i]; ?>">iHeart Radio</option><?php } ?>
                            <?php if(!empty($MuveMusic[$i])) { ?><option value="<?php echo $MuveMusic[$i]; ?>">Muve Music</option><?php } ?>
                            <?php if(!empty($Pandora[$i])) { ?><option value="<?php echo $Pandora[$i]; ?>">Pandora</option><?php } ?>
                            <?php if(!empty($TouchTunes[$i])) { ?><option value="<?php echo $TouchTunes[$i]; ?>">Touch Tunes</option><?php } ?>
                            <?php if(!empty($Myxer[$i])) { ?><option value="<?php echo $Myxer[$i]; ?>">Myxer</option><?php } ?>
                        </select>
                    </form>
                    <?php } ?>
                  </div>
                </div>
                <?php $n=1; }
                } ?>
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>