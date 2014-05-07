<?php
include_once('s.php');
//get id from url
$id = $_REQUEST['id'];
//make sure id is not null and a number
if(!empty($id) && is_numeric($id)) {
	//connect to database
	include_once('php/conn.php');
	//query artists from id
	$text = "SELECT * FROM artists WHERE a_id=$id";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//make sure result is 1
	if(mysqli_num_rows($query)==1) {
		//put results in array
		while ($row = mysqli_fetch_array($query)) {
			$name = strtoupper(stripslashes($row['name']));
			$photo = stripslashes($row['photo']);
			$profile = stripslashes(nl2br($row['profile']));
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
	$text = "SELECT icon, url, file FROM press WHERE artists_a_id=$id";
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
<title>Next Plateau Entertainment | <?php echo $name; ?></title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<link href='http://fonts.googleapis.com/css?family=Karla|Oswald' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css">
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

var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-38924052-1']);
_gaq.push(['_trackPageview']);

(function() {
	var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
	ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
	var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>
</head>
<body onLoad="MM_preloadImages('images/navO_24.png','images/navO_25.png','images/navO_26.png','images/navO_27.png','images/navO_28.png','images/navO_29.png','images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-image:url('images/background-crowd.png'); background-repeat:no-repeat; background-position:center bottom">
	<div style="background-color:#2E2D74; height:102px">
		<div style="width:974px; height:102px; margin:0 auto"><img src="images/subhead-artists.png" width="974" height="102"></div>
	</div>
	<div style="width:974px; margin:0px auto; padding-top:28px">
		<div style="width:974px; height:60px">
			<div style="width:954px; height:50px; float:left; background-image:url(images/tab-artists.png); padding-top:10px; padding-left:20px; color:#fff; font-size:35px; font-family:'Oswald', sans-serif"><?php echo $name; ?></div>
		</div>
		<div style="height:20px"></div>
	</div>
	<div style="height:357px; background-color:#D1D3D4">
		<div style="width:974px; margin:0px auto">
			<div style="width:643px; height:357px; float:left"><img src="artists/<?php echo $photo; ?>" width="643" height="357"></div>
			<div style="width:314px; height:357px; float:right; overflow:visible; background-image:url(images/background.jpg)">
				<div><a href="artists.php"><img src="images/button-featuredartists.png" width="154" height="32" border="0" onMouseOver="this.src='images/button-featuredartistsO.png'" onMouseOut="this.src='images/button-featuredartists.png'"></a><a href="all.php"><img src="images/button-allartists.png" width="154" height="32" border="0" onMouseOver="this.src='images/button-allartistsO.png'" onMouseOut="this.src='images/button-allartists.png'" style="margin-left:6px"></a></div>
				<?php for($i=0; $i<$total_num_rows; $i++) { ?>
				<a href="profile.php?id=<?php echo $a_id[$i]; ?>"><div style="padding-top:8px; padding-bottom:8px; padding-left:25px; border-bottom:#D71F30 solid 1px; color:#808285; font-family:'Oswald', sans-serif" onMouseOver="this.style.backgroundColor='#D71F30'; this.style.color='#fff';" onMouseOut="this.style.backgroundColor='transparent'; this.style.color='#808285';"><?php echo $a_name[$i]; ?></div></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div style="width:974px; margin:0px auto; min-height:<?php echo ($total_num_rows*40)+32; ?>px; height:auto">
		<?php if(!empty($website) || !empty($twitter) || !empty($facebook) || !empty($googleplus) || !empty($instagram) || !empty($youtube) || !empty($soundcloud) || !empty($pinterest) || !empty($lastfm) || !empty($linkedin) || !empty($myspace)) { ?>
		<div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px">ONLINE</div>
		<div style="width:643px; height:65px; padding-top:25px">
		<?php if(!empty($website)) { ?><a href="<?php echo $website; ?>" target="_blank"><img src="images/icon-web.png" alt="Website" border="0" onMouseOver="this.src='images/icon-webO.png'" onMouseOut="this.src='images/icon-web.png'"></a><?php } if(!empty($twitter)) { ?><a href="<?php echo $twitter; ?>" target="_blank"><img src="images/icon-twitter.png" alt="Twitter" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-twitterO.png'" onMouseOut="this.src='images/icon-twitter.png'"></a><?php } if(!empty($facebook)) { ?><a href="<?php echo $facebook; ?>" target="_blank"><img src="images/icon-fb.png" alt="Facebook" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-fbO.png'" onMouseOut="this.src='images/icon-fb.png'"></a><?php } if(!empty($googleplus)) { ?><a href="<?php echo $googleplus; ?>" target="_blank"><img src="images/icon-google.png" alt="Google+" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-googleO.png'" onMouseOut="this.src='images/icon-google.png'"></a><?php } if(!empty($instagram)) { ?><a href="<?php echo $instagram; ?>" target="_blank"><img src="images/icon-instagram.png" alt="Instagram" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-instagramO.png'" onMouseOut="this.src='images/icon-instagram.png'"></a><?php } if(!empty($youtube)) { ?><a href="<?php echo $youtube; ?>" target="_blank"><img src="images/icon-youtube.png" alt="YouTube" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-youtubeO.png'" onMouseOut="this.src='images/icon-youtube.png'"></a><?php } if(!empty($soundcloud)) { ?><a href="<?php echo $soundcloud; ?>" target="_blank"><img src="images/icon-soundcloud.png" alt="Sound Cloud" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-soundcloudO.png'" onMouseOut="this.src='images/icon-soundcloud.png'"></a><?php } if(!empty($pinterest)) { ?><a href="<?php echo $pinterest; ?>" target="_blank"><img src="images/icon-pinterest.png" alt="Pinterest" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-pinterestO.png'" onMouseOut="this.src='images/icon-pinterest.png'"></a><?php } if(!empty($lastfm)) { ?><a href="<?php echo $lastfm; ?>" target="_blank"><img src="images/icon-lastfm.png" alt="Last FM" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-lastfmO.png'" onMouseOut="this.src='images/icon-lastfm.png'"></a><?php } if(!empty($linkedin)) { ?><a href="<?php echo $linkedin; ?>" target="_blank"><img src="images/icon-linkedin.png" alt="LinkedIn" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-linkedinO.png'" onMouseOut="this.src='images/icon-linkedin.png'"></a><?php } if(!empty($myspace)) { ?><a href="<?php echo $myspace; ?>" target="_blank"><img src="images/icon-myspace.png" alt="MySpace" border="0" style="padding-left:17px" onMouseOver="this.src='images/icon-myspaceO.png'" onMouseOut="this.src='images/icon-myspace.png'"></a><?php } ?>
		</div>
		<?php } 
		if($releases_num_rows > 0) { ?>
		<div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">RELEASES</div>
		<div style="width:643px; height:<?php echo ceil($releases_num_rows/3)*300 ?>px; margin-right:331px;">
			<div style="width:643px; height:280px; margin-right:331px; margin-bottom:20px">
				<?php for($i=0; $i<$releases_num_rows; $i++) { 
				if($i>0 && $i%3==0) { ?></div><div style="width:643px; height:280px; margin-right:331px; margin-bottom:20px"><?php } ?>
				<div style="width:160px; height:230px; padding:20px; background-color:#E6E7E8; float:left<?php if(($i+1)%3!=0) echo "; margin-right:21px"; ?>">
					<div><img src="covers/<?php echo $cover[$i]; ?>" width="160" height="160"></div>
					<?php if(!empty($iTunes[$i])) { ?>
						<div style="padding-top:6px; width:44px; float:left"><a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="images/button-itunes-small.png" width="44" height="15"></a></div>
					<?php } ?>
					<div class="site_quick_jump_container" style="width:150px; padding-top:10px; float:left"><?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
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
			<?php } ?>
			</div>
		</div>
		<?php } 
		if(!empty($profile)) { ?>
		<div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px">PROFILE</div>
		<div style="width:643px; padding-top:25px; padding-bottom:30px; font-size:14px; line-height:18px"><?php echo $profile; ?></div>
		<?php }
		if($press_num_rows > 0) { ?>
		<div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">PRESS</div>
		<div style="width:643px; height:150px; padding-bottom:30px">
			<?php for($i=0; $i<$press_num_rows; $i++) { ?>
			<a href="<?php if(!empty($url[$i])) echo $url[$i]; else echo "press/" . $file[$i]; ?>" target="_blank"><div style="height:150px; width:150px; background-image:url(images/pressBG.jpg); margin-right:16px; float:left" onMouseOver="<?php echo $p_id[$i]; ?>.style.width='98px'; <?php echo $p_id[$i]; ?>.style.height='98px'; <?php echo $p_id[$i]; ?>.style.padding='12px'" onMouseOut="<?php echo $p_id[$i]; ?>.style.width='150px'; <?php echo $p_id[$i]; ?>.style.height='150px'; <?php echo $p_id[$i]; ?>.style.padding='0px'"><img id="<?php echo $p_id[$i]; ?>" src="press/<?php echo $icon[$i]; ?>" style="border:#D71F30 solid 1px; width:150px; height:150px"></div></a>
			<?php } ?>
		</div>
		<?php }
		if(!empty($audio)) { ?>
		<div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">AUDIO</div>
		<div style="width:643px; padding-bottom:30px"><?php echo str_replace('&quot;', '"', $audio); ?></div>
		<?php }
		if(!empty($video)) { ?>
		<div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">VIDEO</div>
		<div style="width:643px; padding-bottom:30px"><?php echo str_replace('&quot;', '"', $video); ?></div>
		<?php } ?>
	</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>