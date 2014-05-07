<?php
include_once('s.php');
//connect to database
include_once('php/conn.php');
//query banners
$text = "SELECT name, link FROM banners ORDER BY n";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$total_num_results = mysqli_num_rows($query);
//put results in variables
while ($row = mysqli_fetch_array($query)) {
	$name[] = stripslashes($row['name']);
	$link[] = stripslashes($row['link']);
}
//grab a random featured artist
$text = "SELECT featured.artists_a_id, artists.name, artists.photo FROM featured LEFT JOIN artists ON artists.a_id=featured.artists_a_id ORDER BY RAND() LIMIT 1";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
while ($row = mysqli_fetch_array($query)) {
	$id = $row['artists_a_id'];
	$artist = strtoupper(stripslashes($row['name']));
	$photo = stripslashes($row['photo']);
}
//grab a random featured release
$text = "SELECT cover, title1, title2, artist2, released, iTunes, Amazon, Beatport, eMusic, Spotify, Rhapsody, Deezer, Simfy, GooglePlay, iHeartRadio, MuveMusic, Pandora, TouchTunes, Myxer, artists.name, artists.a_id FROM singles LFET JOIN artists ON artists.a_id=artist1 WHERE featured=1 ORDER BY RAND() LIMIT 1";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
while ($row = mysqli_fetch_array($query)) {
	$cover = stripslashes($row['cover']);
	$title1 = stripslashes($row['title1']);
	$title2 = stripslashes($row['title2']);
	$artist1 = stripslashes($row['name']);
	$artist2 = stripslashes($row['artist2']);
	$a_id = $row['a_id'];
	$released = date("F d, Y", strtotime($row['released']));
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
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau Entertainment | An EDM record company attracting the hottest DJs &amp; Producers Worldwide</title>
<meta name="description" content="Next Plateau Entertainment is one of the top EDM, dance, electronic and dubstep music labels in North America based in NYC.  The company releases the hottest, new soundtracks for the best music festivals, concerts, clubs, events and shows worldwide, while attracting the most talented DJs, Producers, Vocalists, and Songwriters. Next Plateau Entertainment represents 30 years of hit records and a strong publishing catalog of songs.">
<link rel="image_src" href="image.jpg">
<link href='http://fonts.googleapis.com/css?family=Karla|Oswald' rel='stylesheet' type='text/css'>
<link href="style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="nivo-slider.css" type="text/css" media="screen" />
<link rel="stylesheet" href="themes/default/default.css" type="text/css" media="screen" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery.nivo.slider.pack.js" type="text/javascript"></script>
<script type="text/javascript">
$(window).load(function() {
    $('#slider').nivoSlider({
        effect: 'random', // Specify sets like: 'fold,fade,sliceDown'
        slices: 15, // For slice animations
        boxCols: 8, // For box animations
        boxRows: 4, // For box animations
        animSpeed: 500, // Slide transition speed
        pauseTime: 3000, // How long each slide will show
        startSlide: 0, // Set starting Slide (0 index)
        directionNav: true, // Next & Prev navigation
        controlNav: false, // 1,2,3... navigation
        controlNavThumbs: false, // Use thumbnails for Control Nav
        pauseOnHover: true, // Stop animation while hovering
        manualAdvance: false, // Force manual transitions
        prevText: 'Prev', // Prev directionNav text
        nextText: 'Next', // Next directionNav text
        randomStart: false, // Start on a random slide
        beforeChange: function(){}, // Triggers before a slide transition
        afterChange: function(){}, // Triggers after a slide transition
        slideshowEnd: function(){}, // Triggers after all slides have been shown
        lastSlide: function(){}, // Triggers when last slide is shown
        afterLoad: function(){} // Triggers when slider has loaded
    });
});

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
<body onLoad="MM_preloadImages('images/navO_24.png','images/navO_25.png','images/navO_26.png','images/navO_27.png','images/navO_28.png','images/navO_29.png')">
<?php include_once('header.php'); ?>
<div style="background-image:url('images/background-crowd.png'); background-repeat:no-repeat; background-position:center bottom">
	<div style="height:355px" class="slider-wrapper theme-default">
		<div style="width:974px; height:355px; margin:0 auto; overflow:hidden" id="slider" class="nivoSlider">
			<?php for($i=0; $i<$total_num_results; $i++) { 
				if(!empty($link[$i])) { echo "<a href='" . $link[$i] . "'>"; } ?><img src="banners/<?php echo $name[$i] . '">'; if(!empty($link[$i])) echo "</a>";
			} ?>
		</div>
	</div>
	<div style="height:350px; width:974px; padding-top:25px; margin:0px auto">
		<div style="width:475px; height:65px; float:left"><img src="images/tab-featured-artist.png" width="475" height="65"></div>
		<div style="width:475px; height:65px; float:right"><img src="images/tab-featured-release.png"></div>
		<div style="width:475px; height:262px; padding-top:8px; float:left">
		<a href="profile.php?id=<?php echo $id; ?>"><div style="width:475px; height:62px; padding-top:200px; background-image:url(artists/<?php echo $photo; ?>); background-size:475px 262px">
				<div style="float:left; background-color:#D71F30; height:38px; line-height:32px; font-size:26px; font-family:'Oswald', sans-serif; color:#fff; padding:3px 6px"><?php echo $artist; ?></div>
		</div></a>
		</div>
		<div style="width:475px; height:262px; padding-top:8px; float:right">
			<div style="width:262px; height:262px; float:left"><a href="profile.php?id=<?php echo $a_id; ?>"><img src="covers/<?php echo $cover; ?>" width="262" height="262" border="0"></a></div>
			<div style="width:197px; height:262px; padding-left:16px; float:right">
				<div style="font-family:'Oswald', sans-serif; font-size:18px; color:#231F20"><?php echo $title1; ?></div>
				<div style="font-size:14px; border-bottom:#F00 solid 2px; padding-bottom:4px"><?php if(!empty($title2)) { ?>(<?php echo $title2; ?>)<?php } ?></div>
				<div style="padding-top:8px; font-size:16px"><?php echo $artist1; ?></div>
				<div style="font-size:14px"><?php if(!empty($artist2)) { ?><?php echo $artist2; } ?></div>
				<div style="padding-top:6px; font-size:14px"><a href="profile.php?id=<?php echo $a_id; ?>">Visit Artist Profile</a></div>
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
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>