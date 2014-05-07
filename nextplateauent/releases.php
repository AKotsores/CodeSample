<?php
include_once('s.php');
//connect to database
include_once('php/conn.php');
//query featured singles
$text = "SELECT cover, title1, title2, artist1, artist2, released, iTunes, Amazon, Beatport, eMusic, Spotify, Rhapsody, Deezer, Simfy, GooglePlay, iHeartRadio, MuveMusic, Pandora, TouchTunes, Myxer, artists.name, artists.a_id FROM singles LFET JOIN artists ON artists.a_id=artist1 WHERE featured=1 ORDER BY n, released DESC";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$total_num_results = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$a_id[] = $row['artist1'];
	$artist1[] = stripslashes($row['name']);
	$artist2[] = stripslashes($row['artist2']);
	$title1[] = stripslashes($row['title1']);
	$title2[] = stripslashes($row['title2']);
	$cover[] = stripslashes($row['cover']);
	$released[] = date("F d, Y", strtotime($row['released']));
	$order[] = $row['n'];
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
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau Entertainment | Featured Releases</title>
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
<body onLoad="MM_preloadImages('images/navO_24.png','images/navO_25.png','images/navO_26.png','images/navO_27.png','images/navO_28.png','images/navO_29.png','images/browseO_02.png','images/a_browse_03.png')">
<?php include_once('header.php'); ?>
<div style="background-image:url('images/background-crowd.png'); background-repeat:no-repeat; background-position:center bottom">
	<div style="background-color:#2E2D74; height:102px">
		<div style="width:974px; height:102px; margin:0px auto"><img src="images/subhead-releases.png"></div>
	</div>
	<div style="width:974px; margin:0px auto; padding-top:28px">
		<div><img src="images/a_browse_01.png"><img src="images/a_browse_02.png" width="165" height="60"><a href="allreleases.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AllReleases','','images/a_browse_03.png',1)"><img src="images/a_browseO_03.png" alt="All Releases" name="AllReleases" width="111" height="60" border="0"></a><img src="images/a_browse_04.png" width="391" height="60"></div>
	<div style="height:30px"></div>
		<div style="width:974px; height:<?php echo ceil($total_num_results/2)*286; ?>px">
			<div style="width:974px; height:220px; padding-bottom:20px">
				<?php for ($i=0; $i<$total_num_results; $i++) { ?>
					<div style="width:445px; height:232px; margin-bottom:24px; float:<?php if($i%2==0) echo "left"; else echo "right"; ?>; background-color:#E6E7E8; padding:15px">
						<div style="width:232px; height:232px; float:left"><a href="profile.php?id=<?php echo $a_id[$i]; ?>"><img src="covers/<?php echo $cover[$i]; ?>" width="232" height="232" border="0"></a></div>
						<div style="width:197px; height:262px; padding-left:16px; float:right">
							<div style="font-family:'Oswald', sans-serif; font-size:18px; color:#231F20"><?php echo $title1[$i]; ?></div>
							<div style="font-size:14px; border-bottom:#F00 solid 2px; padding-bottom:4px"><?php if(!empty($title2[$i])) { ?>(<?php echo $title2[$i]; ?>)<?php } ?></div>
							<div style="padding-top:8px; font-size:16px"><?php echo $artist1[$i]; ?></div>
							<div style="font-size:14px"><?php if(!empty($artist2[$i])) { ?><?php echo $artist2[$i]; } ?></div>
							<div style="padding-top:3px; font-size:14px"><a href="profile.php?id=<?php echo $a_id[$i]; ?>">Visit Artist Profile</a></div>
							<div style="color:#231F20; font-size:16px; font-weight:bold; padding-top:6px">Release Date</div>
							<div style="font-size:14px"><?php echo $released[$i]; ?><br>
							<a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="images/button-itunes-large.png" border="0" style="padding-top:5px"></a></div>
							<div class="site_quick_jump_container" style="padding-top:5px">
							<?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
							<form id="site_quick_jump_form" method="get" action="">
								<select class="site_quick_jump" style="width:197px; height:23px; border:none; background-color:#A7A9AC; color:#fff">
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
					</div>
				<?php } ?>
			</div>
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>