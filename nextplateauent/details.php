<?php
include_once('s.php');
//get id from url
$id = $_REQUEST['id'];
//make sure id is not null and a number
if(!empty($id) && is_numeric($id)) {
	//connect to database
	include_once('php/conn.php');
	//query compilation from id
	$text = "SELECT * FROM compilations WHERE c_id=$id";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//make sure result is 1
	if(mysqli_num_rows($query)==1) {
		//put results in array
		while ($row = mysqli_fetch_array($query)) {
			$title1 = strtoupper(stripslashes($row['title1']));
			$title2 = stripslashes($row['title2']);
			$description = stripslashes($row['description']);
			$released = date("F d, Y", strtotime($row['released']));
			$cover = stripslashes($row['cover']);
			$audio = stripslashes($row['audio']);
			$video = stripslashes($row['video']);
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
	}
	else {
		mysqli_close($dbc);
		header('Location: index.php');
		exit;
	}
	//get all compilations
	$text = "SELECT c_id, title1 FROM compilations ORDER BY title1";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//get number of compilations
	$total_num_rows = mysqli_num_rows($query);
	//put results in array
	while ($row = mysqli_fetch_array($query)) {
		$c_id[] = $row['c_id'];
		$c_title[] = strtoupper(stripslashes($row['title1']));
	}
	//get tracklist for current compilation
	$text = "SELECT number, track, artist, duration, iTunes FROM tracklist WHERE compilations_c_id=$id ORDER BY number";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//get number of tracks
	$track_num_rows = mysqli_num_rows($query);
	//put results in array
	while ($row = mysqli_fetch_array($query)) {
		$number[] = stripslashes($row['number']);
		$song[] = stripslashes($row['track']);
		$artist[] = stripslashes($row['artist']);
		$length[] = stripslashes($row['duration']);
		$buy[] = stripslashes($row['iTunes']);
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
<title>Next Plateau Entertainment | <?php echo $title1; ?></title>
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
		<div style="width:974px; height:102px; margin:0 auto"><img src="images/subhead-compilations.png" width="974" height="102"></div>
	</div>
	<div style="width:974px; margin:0px auto; padding-top:28px">
		<div style="width:974px; height:60px">
			<div style="width:623px; height:50px; float:left; background-image:url(images/tab-artist.png); padding-top:10px; padding-left:20px; color:#fff; font-size:35px; font-family:'Oswald', sans-serif"><?php echo $title1; ?></div>
			<div style="width:314px; height:60px; float:right"><img src="images/tab-comp.png" width="314" height="60"></div>
		</div>
		<div style="height:20px"></div>
	</div>
	<div style="height:357px; background-color:#D1D3D4">
		<div style="width:974px; margin:0px auto">
			<div style="width:357px; height:357px; float:left"><img src="covers/<?php echo $cover; ?>" width="357" height="357"></div>
			<div style="width:256px; height:327px; float:left; padding:15px">
				<div style="font-family:'Oswald', sans-serif; font-size:18px; color:#231F20"><?php echo $title1; ?></div>
				<div style="font-size:14px; border-bottom:#F00 solid 2px; padding-bottom:4px"><?php if(!empty($title2)) { echo $title2; } ?></div>
				<div style="padding-top:8px; font-size:16px"><?php echo $description; ?></div>
				<div style="color:#231F20; font-size:16px; font-weight:bold; padding-top:14px">Release Date</div>
				<div style="font-size:14px"><?php echo $released; ?><br><br>
				<a href="<?php echo $iTunes; ?>" target="_blank"><img src="images/button-itunes-large.png" border="0" style="padding-top:5px"></a></div>
				<div class="site_quick_jump_container" style="padding-top:5px">
				<?php if(!empty($Amazon) || !empty($Beatport) || !empty($eMusic) || !empty($Spotify) || !empty($Rhapsody) || !empty($Deezer) || !empty($Simfy) || !empty($GooglePlay) || !empty($iHeartRadio) || !empty($MuveMusic) || !empty($Pandora) || !empty($TouchTunes) || !empty($Myxer)) { ?>
				<form id="site_quick_jump_form" method="get" action="">
					<select class="site_quick_jump" style="width:197px; height:23px; border:none; background-color:#A7A9AC; color:#fff">
						<option>or Download on...</option>
						<?php if(!empty($Amazon)) { ?><option value="<?php echo $Amazon; ?>">Amazon</option><?php } ?>
						<?php if(!empty($Beatport)) { ?><option value="<?php echo $Beatport; ?>">Beatport</option><?php } ?>
						<?php if(!empty($eMusic)) { ?><option value="<?php echo $eMusic; ?>">eMusic</option><?php } ?>
						<?php if(!empty($Spotify)) { ?><option value="<?php echo $Spotify; ?>">Spotify</option><?php } ?>
						<?php if(!empty($Rhapsody)) { ?><option value="<?php echo $Rhapsody; ?>">Rhapsody</option><?php } ?>
						<?php if(!empty($Deezer)) { ?><option value="<?php echo $Deezer; ?>">Deezer</option><?php } ?>
						<?php if(!empty($Simfy)) { ?><option value="<?php echo $Simfy; ?>">Simfy</option><?php } ?>
						<?php if(!empty($GooglePlay)) { ?><option value="<?php echo $GooglePlay; ?>">Google Play</option><?php } ?>
						<?php if(!empty($iHeartRadio)) { ?><option value="<?php echo $iHeartRadio; ?>">iHeart Radio</option><?php } ?>
						<?php if(!empty($MuveMusic)) { ?><option value="<?php echo $MuveMusic; ?>">Muve Music</option><?php } ?>
						<?php if(!empty($Pandora)) { ?><option value="<?php echo $Pandora; ?>">Pandora</option><?php } ?>
						<?php if(!empty($TouchTunes)) { ?><option value="<?php echo $TouchTunes; ?>">Touch Tunes</option><?php } ?>
						<?php if(!empty($Myxer)) { ?><option value="<?php echo $Myxer; ?>">Myxer</option><?php } ?>
					</select>
				</form>
				<?php } ?>
				</div>
			</div>
			<div style="width:314px; height:357px; float:right; overflow:visible; background-image:url(images/background.jpg)">
				<?php for($i=0; $i<$total_num_rows; $i++) { ?>
				<a href="details.php?id=<?php echo $c_id[$i]; ?>"><div style="padding-top:8px; padding-bottom:8px; padding-left:25px; border-bottom:#D71F30 solid 1px; color:#808285; font-family:'Oswald', sans-serif" onMouseOver="this.style.backgroundColor='#D71F30'; this.style.color='#fff';" onMouseOut="this.style.backgroundColor='transparent'; this.style.color='#808285';"><?php echo $c_title[$i]; ?></div></a>
				<?php } ?>
			</div>
		</div>
	</div>
	<div style="width:974px; margin:0px auto">
		<?php if($track_num_rows>0) { ?>
		<div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">TRACKLISTING</div>
		<div style="width:643px; margin-right:331px; padding-bottom:30px">
			<div style="padding-bottom:30px; font-size:14px; font-weight:bold">
				<div style="width:32px; padding-left:10px; float:left">No.</div><div style="width:268px; float:left">Track</div><div style="width:203px; float:left">Artist</div><div style="width:127px; float:left">Duration
				</div>
			</div>
			<?php $n=1; for($i=0; $i<$track_num_rows; $i++) { ?>
			<div style="height:<?php if(strlen($song[$i])>40 || strlen($artist[$i])>25) echo "50px"; else echo "25px"; ?>; font-size:14px; line-height:25px<?php if($n%2 != 0) echo "; background-color:#dcdddf"; ?>">
				<div style="width:32px; float:left; padding-left:12px"><?php echo $number[$i]; ?></div>
				<div style="width:268px; float:left"><?php /*if(strlen($song[$i]) > 40) echo str_replace('(', '<br>(', $song[$i]); else*/ echo $song[$i]; ?></div>
				<div style="width:203px; float:left"><?php /*if(strlen($artist[$i]) > 25) echo str_replace('f/', '<br>f/', $artist[$i]); else*/ echo $artist[$i]; ?></div>
				<div style="width:73px; float:left"><?php echo $length[$i]; ?></div>
				<?php if(!empty($buy[$i])) { ?><div style="width:44px; height:22px; float:right; padding-right:10px; padding-top:3px"><a href="<?php echo $buy[$i]; ?>" target="_blank"><img src="images/button-itunes-small.png" border="0"></a></div><?php } ?>
			</div>
			<?php $n++; } ?>
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
</div>
<?php include_once('footer.php'); ?>
</body>
</html>