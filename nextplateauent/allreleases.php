<?php
include_once('s.php');
//connect to database
include_once('php/conn.php');
//query featured singles
$text = "SELECT cover, title1, title2, artist1, artist2, released, iTunes, Amazon, Beatport, eMusic, Spotify, Rhapsody, Deezer, Simfy, GooglePlay, iHeartRadio, MuveMusic, Pandora, TouchTunes, Myxer, artists.name, artists.a_id FROM singles LFET JOIN artists ON artists.a_id=artist1 ORDER BY released DESC";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$total_num_results = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$a_id[] = $row['artist1'];
	$title1[] = stripslashes($row['title1']);
	$title2[] = $row['title2'];
	$artist1[] = $row['name'];
	$artist2[] = $row['artist2'];
	$released[] = date("F d, Y", strtotime($row['released']));
	$date[] = date("Y-m-d", strtotime($row['released']));
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
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau Entertainment | All Releases</title>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
<script src="jquery.isotope.min.js"></script>
<script>
$(function(){
	var $container = $('#container');
	
	$container.isotope({
        itemSelector : '.element',
        getSortData : {
          date : function( $elem ) {
            return $elem.find('.date').text();
          },
          artist : function ( $elem ) {
            return $elem.find('.artist').text();
          },
		  song : function ( $elem ) {
            return $elem.find('.song').text();
          }
        }
      });
      
      var $optionSets = $('#options .option-set'),
          $optionLinks = $optionSets.find('a');

      $optionLinks.click(function(){
        var $this = $(this);
        // don't proceed if already selected
        if ( $this.hasClass('selected') ) {
          return false;
        }
        var $optionSet = $this.parents('.option-set');
        $optionSet.find('.selected').removeClass('selected');
        $this.addClass('selected');
  
        // make option object dynamically, i.e. { filter: '.my-filter-class' }
        var options = {},
            key = $optionSet.attr('data-option-key'),
            value = $this.attr('data-option-value');
        // parse 'false' as false boolean
        value = value === 'false' ? false : value;
        options[ key ] = value;
        if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
          // changes in layout modes need extra logic
          changeLayoutMode( $this, options )
        } else {
          // otherwise, apply new options
          $container.isotope( options );
        }
        
        return false;
	});
});
</script>
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
<link rel="stylesheet" href="style2.css">
</head>
<body onLoad="MM_preloadImages('images/navO_24.png','images/navO_25.png','images/navO_26.png','images/navO_27.png','images/navO_28.png','images/navO_29.png','images/browseO_02.png','images/a_browse_02.png')">
<?php include_once('header.php'); ?>
<div style="background-image:url('images/background-crowd.png'); background-repeat:no-repeat; background-position:center bottom">
	<div style="background-color:#2E2D74; height:102px">
		<div style="width:974px; height:102px; margin:0px auto"><img src="images/subhead-releases.png"></div>
	</div>
	<div style="width:974px; margin:0px auto; padding-top:28px">
		<div><img src="images/a_browse_01.png"><a href="releases.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('FeaturedReleases','','images/a_browse_02.png',1)"><img src="images/a_browseO_02.png" alt="Featured Releases" name="FeaturedReleases" width="165" height="60" border="0"></a><img src="images/a_browse_03.png" width="111" height="60"><img src="images/a_browse_04.png" width="391" height="60"></div>
	<div style="height:30px"></div>
	<div>
		<section id="options" class="clearfix">
		<div style="float:left; line-height:32px; padding-bottom:10px">Sort By</div>
		<div style="float:left; margin-right:25px; line-height:32px; padding-bottom:10px; margin-left:-20px">
		<ul id="sort-by" class="option-set clearfix" data-option-key="sortBy">
		  <li><a href="#sortBy=date" data-option-value="date" class="selected">RELEASE DATE</a></li>
		  <li><a href="#sortBy=artist" data-option-value="artist">ARTIST</a></li>
		  <li><a href="#sortBy=song" data-option-value="song">SONG</a></li>
		</ul>
		</div>
		<div style="float:left; line-height:32px; padding-bottom:10px">Sort Direction</div>
		<div style="float:left; margin-right:25px; line-height:32px; padding-bottom:10px; margin-left:-20px">
		<ul id="sort-direction" class="option-set clearfix" data-option-key="sortAscending">
		  <li><a href="#sortAscending=true" data-option-value="true" class="selected">ASCENDING</a></li>
		  <li><a href="#sortAscending=false" data-option-value="false">DESCENDING</a></li>
		</ul>
		</div>
		</section>
	</div>
	<div style="width:974px; height:<?php echo ceil($total_num_results/4)*450; ?>px; padding-bottom:20px" id="container" class="clearfix">
		<?php for ($i=0; $i<$total_num_results; $i++) { ?>
		<div style="width:200px; height:400px; padding:15px; background-color:#E6E7E8; float:left; margin:5px" class="element">
			<div><a href="profile.php?id=<?php echo $a_id[$i]; ?>"><img src="covers/<?php echo $cover[$i]; ?>" width="200" height="200" border="0"></a></div>
			<div style="font-family:'Oswald', sans-serif; font-size:18px; color:#231F20" class="song"><?php echo $title1[$i]; ?></div>
			<div style="font-size:14px; border-bottom:#F00 solid 2px; padding-bottom:4px"><?php if(!empty($title2[$i])) { ?>(<?php echo $title2[$i]; ?>)<?php } ?></div>
			<div style="padding-top:8px; font-size:16px" class="artist"><?php echo $artist1[$i]; ?></div>
			<div style="font-size:14px"><?php if(!empty($artist2[$i])) { ?><?php echo $artist2[$i]; } ?></div>
			<div style="padding-top:3px; font-size:14px"><a href="profile.php?id=<?php echo $a_id[$i]; ?>">Visit Artist Profile</a></div>
			<div style="color:#231F20; font-size:16px; font-weight:bold; padding-top:6px">Release Date</div>
			<div style="font-size:14px"><?php echo $released[$i]; ?></div>
			<div style="width:0px; height:0px; overflow:hidden" class="date"><?php echo $date[$i]; ?></div>
			<?php if(!empty($iTunes[$i])) { ?><div style="padding-top:10px; width:44px; float:left"><a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="images/button-itunes-small.png" border="0"></a></div><?php } ?>
			<div class="site_quick_jump_container" style="width:146px; padding-left:10px; padding-top:6px; float:left">
			<?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
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
	</div></div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>