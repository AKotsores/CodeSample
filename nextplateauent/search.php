<?php
include_once('s.php');
//connect to database
include_once('php/conn.php');
//get phrase to query
$lookup = mysqli_real_escape_string($dbc, $_REQUEST['id']);
//if lookup is empty go home
if(empty($lookup)) {
	//close connection
	mysqli_close($dbc);
	//redirect to home
	header('Location: index.php');
	exit;
}
else
	$lookup = str_replace(',', ' ', $lookup);
$search_words = explode(' ', $lookup);
//query releases
$text = "SELECT cover, iTunes, Amazon, Beatport, eMusic, Spotify, Rhapsody, Deezer, Simfy, GooglePlay, iHeartRadio, MuveMusic, Pandora, TouchTunes, Myxer  FROM singles, artists";
$where_list = array();
foreach ($search_words as $word) {
	if(!empty($word)) {
		$where_list[] = "artists.name LIKE '%$word%' OR artist2 LIKE '%$word%' OR title1 LIKE '%$word%' OR title2 LIKE '%$word%'";
	}
}
$where_clause = implode(' OR ', $where_list);
if(!empty($where_clause)) {
	$text .= " WHERE ($where_clause) AND artist1 = artists.a_id";
}
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$releases_num_results = mysqli_num_rows($query);
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
//query artists
$text = "SELECT a_id, name, photo FROM artists";
$where_list = array();
foreach ($search_words as $word) {
	if(!empty($word)) {
		$where_list[] = "name LIKE '%$word%'";
	}
}
$where_clause = implode(' OR ', $where_list);
if(!empty($where_clause)) {
	$text .= " WHERE ($where_clause) ORDER BY name";
}
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$artists_num_results = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$a_id[] = $row['a_id'];
	$name[] = strtoupper(stripslashes($row['name']));
	$photo[] = stripslashes($row['photo']);
}
//query compilations

//query publishing
$text = "SELECT * FROM catalog";
$where_list = array();
foreach ($search_words as $word) {
	if(!empty($word)) {
		$where_list[] = "song LIKE '%$word%' OR artist LIKE '%$word%' OR writers LIKE '%$word%'";
	}
}
$where_clause = implode(' OR ', $where_list);
if(!empty($where_clause)) {
	$text .= " WHERE ($where_clause) ORDER BY song";
}
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$publishing_num_results = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$song[] = stripslashes($row['song']);
	$artist[] = stripslashes($row['artist']);
	$writers[] = stripslashes($row['writers']);
}
//close database connection
mysqli_close($dbc);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau</title>
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
		<div style="width:974px; height:102px; margin:0px auto"><img src="images/subhead-search.png" width="974" height="102"></div>
	</div>
	<div style="width:974px; margin:0px auto; padding-top:28px">
		<?php if($releases_num_results>0) { ?>
		<div style="width:974px; height:23px; padding-top:15px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:15px">RELEASES</div>
		<div style="width:974px; height:<?php echo ceil($releases_num_results/4)*280; ?>px">
			<div style="width:974px; height:220px; padding-bottom:20px">
				<?php $n=1; for ($i=0; $i<$releases_num_results; $i++) { 
					if($n==1) { if($i>0 && $n==1) { ?></div><div style="width:974px; height:220px; padding-bottom:20px"><?php } ?>
					<div style="width:200px; height:230px; padding:15px; background-color:#E6E7E8; float:left; margin-right:18px; margin-bottom:18px">
					<div><img src="covers/<?php echo $cover[$i]; ?>" width="200" height="200"></div>
					<?php if(!empty($iTunes[$i])) { ?><div style="padding-top:10px; width:44px; float:left"><a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="images/button-itunes-small.png" border="0"></a></div><?php } ?>
					<div class="site_quick_jump_container" style="width:146px; padding-left:10px; padding-top:6px; float:left"><?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
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
					<div style="width:200px; height:230px; padding:15px; background-color:#E6E7E8; float:left; margin-right:18px; margin-bottom:18px">
					<div><img src="covers/<?php echo $cover[$i]; ?>" width="200" height="200"></div>
					<?php if(!empty($iTunes[$i])) { ?><div style="padding-top:10px; width:44px; float:left"><a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="images/button-itunes-small.png" border="0"></a></div><?php } ?>
					<div class="site_quick_jump_container" style="width:146px; padding-left:10px; padding-top:6px; float:left"><?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
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
					else if($n==3) { ?>
					<div style="width:200px; height:230px; padding:15px; background-color:#E6E7E8; float:left; margin-right:18px; margin-bottom:18px">
					<div><img src="covers/<?php echo $cover[$i]; ?>" width="200" height="200"></div>
					<?php if(!empty($iTunes[$i])) { ?><div style="padding-top:10px; width:44px; float:left"><a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="images/button-itunes-small.png" border="0"></a></div><?php } ?>
					<div class="site_quick_jump_container" style="width:146px; padding-left:10px; padding-top:6px; float:left"><?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
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
					else if($n==4) { ?>
					<div style="width:200px; height:230px; padding:15px; background-color:#E6E7E8; float:left; margin-bottom:18px">
					<div><img src="covers/<?php echo $cover[$i]; ?>" width="200" height="200"></div>
					<?php if(!empty($iTunes[$i])) { ?><div style="padding-top:10px; width:44px; float:left"><a href="<?php echo $iTunes[$i]; ?>" target="_blank"><img src="images/button-itunes-small.png" border="0"></a></div><?php } ?>
					<div class="site_quick_jump_container" style="width:146px; padding-left:10px; padding-top:6px; float:right"><?php if(!empty($Amazon[$i]) || !empty($Beatport[$i]) || !empty($eMusic[$i]) || !empty($Spotify[$i]) || !empty($Rhapsody[$i]) || !empty($Deezer[$i]) || !empty($Simfy[$i]) || !empty($GooglePlay[$i]) || !empty($iHeartRadio[$i]) || !empty($MuveMusic[$i]) || !empty($Pandora[$i]) || !empty($TouchTunes[$i]) || !empty($Myxer[$i])) { ?>
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
			</div>
		</div>
		<?php } 
		if($artists_num_results>0) { ?>
		<div style="width:974px; height:23px; padding-top:15px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:15px">ARTISTS</div>
		<div style="width:974px; height:174px; padding-bottom:16px">
			<?php $n=1; for ($i=0; $i<$artists_num_results; $i++) { 
				if($n==1) { if($i>0 && $i%3==0) { ?></div><div style="width:974px; height:174px; padding-bottom:16px"><?php } ?>
				<a href="profile.php?id=<?php echo $a_id[$i]; ?>"><div style="width:314px; height:39px; padding-top:135px; background-image:url(artists/<?php echo $photo[$i]; ?>); background-size:314px 174px; float:left; margin-right:16px">
					<div style="float:left; background-color:#D71F30; height:21px; line-height:21px; font-size:18px; font-family:'Oswald', sans-serif; color:#fff; padding:3px 6px"><?php echo $name[$i]; ?></div>
				</div></a>
				<?php $n++; }
				else if($n==2) { ?>
				<a href="profile.php?id=<?php echo $a_id[$i]; ?>"><div style="width:314px; height:39px; padding-top:135px; background-image:url(artists/<?php echo $photo[$i]; ?>); background-size:314px 174px; float:left">
					<div style="float:left; background-color:#D71F30; height:21px; line-height:21px; font-size:18px; font-family:'Oswald', sans-serif; color:#fff; padding:3px 6px"><?php echo $name[$i]; ?></div>
				</div></a>
				<?php $n++; }
				else if($n==3) { ?>
				<a href="profile.php?id=<?php echo $a_id[$i]; ?>"><div style="width:314px; height:39px; padding-top:135px; background-image:url(artists/<?php echo $photo[$i]; ?>); background-size:314px 174px; float:right">
					<div style="float:left; background-color:#D71F30; height:21px; line-height:21px; font-size:18px; font-family:'Oswald', sans-serif; color:#fff; padding:3px 6px"><?php echo $name[$i]; ?></div>
				</div></a>
				<?php $n=1; }
			} ?>
		</div>
		<?php } 
		if($publishing_num_results>0) { ?>
		<div style="width:974px; height:23px; padding-top:15px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:15px">PUBLISHING</div>
		<div style="width:974px; padding-bottom:20px">
		<?php $n=1; for($i=0; $i<$publishing_num_results; $i++) { ?>
		<div style="width:974px; height:<?php if(strlen($song[$i])>43 || strlen($artist[$i])>40 || strlen($writers[$i])>57) echo "50px"; else echo "25px"; ?>; font-size:14px; line-height:25px<?php if($n%2 != 0) echo "; background-color:#dcdddf"; ?>">
			<div style="width:250px; float:left; margin-right:16px; padding-left:6px"><?php echo $song[$i]; ?></div>
			<div style="width:270px; float:left; margin-right:16px; padding-left:6px"><?php echo $artist[$i]; ?></div>
			<div style="width:400px; float:left; padding-left:6px"><?php echo $writers[$i]; ?></div>
		</div>
		<?php $n++; } ?>
		</div>
		<?php }
		if($artists_num_results==0 && $releases_num_results==0 && $publishing_num_results==0) { ?>
		<div style="width:974px; height:23px; padding-top:15px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:15px">NO RESULTS FOUND</div>
		<div style="width:974px; height:250px; margin-bottom:16px">Sorry, your search did not return any results. Try searching for a different artist, release, compilation or keyword.</div>
		<?php } ?>
	</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>