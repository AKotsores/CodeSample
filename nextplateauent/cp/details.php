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
	//query compilation from id
	$text = "SELECT * FROM compilations WHERE c_id=$id";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//make sure result is 1
	if(mysqli_num_rows($query)==1) {
		if(isset( $_POST['content'] ) || isset( $_POST['content_x']) ) {
			include_once('php/sysvars.php');
			//put results in variables
			$t1 = mysqli_real_escape_string($dbc, trim($_POST['t1']));
			$t2 = mysqli_real_escape_string($dbc, trim($_POST['t2']));
			$image = str_replace(" ", "", $_FILES['cover'] ['name']);
			$description = mysqli_real_escape_string($dbc, trim($_POST['description']));
			$released = mysqli_real_escape_string($dbc, trim($_POST['released']));
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
			$audio = mysqli_real_escape_string($dbc, trim(str_replace('"', '&quot;', $_POST['Audio'])));
			$video = mysqli_real_escape_string($dbc, trim(str_replace('"', '&quot;', $_POST['Video'])));
			
			$insertTXT = $valuesTXT = '';
			//replace images
			if(!empty($image)) {
				$insertTXT .= ", cover='$image'";
				$target = GW_UPLOADPATH_COVER . $image;
				move_uploaded_file($_FILES['cover'] ['tmp_name'], $target)
					or die("Error moving flyer");
			}
			
			//update record
			$text = "UPDATE compilations SET title1='$t1', title2='$t2', description='$description', released='$released', audio='$audio', video='$video', iTunes='$itunes', Amazon='$amazon', Beatport='$beatport', eMusic='$emusic', Spotify='$spotify', Rhapsody='$rhapsody', Deezer='$deezer', Simfy='$simfy', GooglePlay='$google', iHeartRadio='$iheart', MuveMusic='$muve', Pandora='$pandora', TouchTunes='$touch', Myxer='$myxer' $insertTXT WHERE c_id='$id'";
			$query = mysqli_query($dbc, $text)
				or die("Error executing query: " . mysqli_error($dbc));
			//record in log
			$u_id = $_COOKIE['u_id'];
			$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'compilations', $id, 'compilation record edited', (NOW() + INTERVAL 3 HOUR))";
			mysqli_query($dbc, $text)
				or die('Error updating log: ' . mysqli_error($dbc));
			//close database connection
			mysqli_close($dbc);
			//refresh page
			header('Location: details.php?id=' . $id);
		}
		else {
			//put results in array
			while ($row = mysqli_fetch_array($query)) {
				$cover = stripslashes($row['cover']);
				$title1 = strtoupper(stripslashes($row['title1']));
				$title2 = stripslashes($row['title2']);
				$description = stripslashes($row['description']);
				$released = $row['released'];
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
	return confirm('Are you sure you want to delete this compilation?')
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png','../images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-compilations.png" width="974" height="102"></div>
</div>
<form action="details.php?id=<?php echo $id; ?>" method="post" enctype="multipart/form-data">
<div style="width:974px; margin:0px auto; padding-top:5px">
<input type="image" src="images/button-update-comp.png" border="0" alt="Submit" name="content"> 
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="deletecomp.php?id=<?php echo $id; ?>" onClick="return verify()"><img src="images/button-delete-comp.png" border="0"> </a></div>
<div style="width:974px; margin:0px auto; padding-top:28px">
	<div style="width:974px; height:60px">
    	<div style="width:623px; height:50px; float:left; background-image:url(../images/tab-artist.png); padding-top:10px; padding-left:20px; color:#fff; font-size:35px; font-family:'Oswald', sans-serif"><?php echo $title1; ?></div>
        <div style="width:314px; height:60px; float:right"><img src="../images/tab-comp.png" width="314" height="60"></div>
    </div>
    <div style="height:20px"></div>
</div>
<div style="height:357px; background-color:#D1D3D4">
	
	<div style="width:974px; margin:0px auto">
        <div style="width:357px; height:357px; float:left"><img src="../covers/<?php echo $cover; ?>" width="357" height="357"></div>
        <div style="width:256px; height:327px; float:left; padding:15px">
        	<div style="font-family:'Oswald', sans-serif; font-size:18px; color:#231F20"><input name="t1" type="text" id="t1" value="<?php echo $title1; ?>" style="width:252px"></div>
            <div style="font-size:14px; border-bottom:#F00 solid 2px; padding-bottom:4px"><input name="t2" type="text" id="t2" value="<?php echo $title2; ?>" style="width:252px"></div>
            <div style="padding-top:8px; font-size:16px">
              <textarea name="description" style="width:252px; height:50px"><?php echo $description; ?></textarea></div>
            <div style="color:#231F20; font-size:16px; font-weight:bold; padding-top:14px">Release Date <font size="-1">(YYYY-MM-DD)</font></div>
            <div style="font-size:14px"><input name="released" type="text" id="released" value="<?php echo $released; ?>" style="width:252px"><br><br>
            <a href="<?php echo $iTunes; ?>" target="_blank"><img src="../images/button-itunes-large.png" border="0" style="padding-top:5px"></a></div>
        </div>
        <div style="width:314px; height:357px; float:right; overflow:visible; background-image:url(../images/background.jpg)">
            <?php for($i=0; $i<$total_num_rows; $i++) { ?>
            <a href="details.php?id=<?php echo $c_id[$i]; ?>"><div style="padding-top:8px; padding-bottom:8px; padding-left:25px; border-bottom:#D71F30 solid 1px; color:#808285; font-family:'Oswald', sans-serif" onMouseOver="this.style.backgroundColor='#D71F30'; this.style.color='#fff';" onMouseOut="this.style.backgroundColor='transparent'; this.style.color='#808285';"><?php echo $c_title[$i]; ?></div></a>
            <?php } ?>
        </div>
    </div>
</div>
<div style="width:974px; margin:0px auto">
<div style="height:585px">
	<div style="padding-top:15px; padding-bottom:15px; width:974px; margin:0px auto"></div>
    <div style="width:150px; float:left; height:35px; line-height:35px">Update Cover: </div><div style="width:800px; height:35px; float:right"><input name="cover" type="file" style="width:250px; height:25px"><font size="-2" color="#D71F30">*Cover image is 308 pixels wide and 308 pixels high</font></div>
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

    </div>
	<div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">TRACKLISTING &nbsp;&nbsp;&nbsp;<a href="editplaylist.php?id=<?php echo $id; ?>"><img src="images/button-edit-tracks.png" border="0"></a></div>
    <div style="width:643px; margin-right:331px; padding-bottom:30px">
        <div style="padding-bottom:30px; font-size:14px; font-weight:bold">
    		<div style="width:32px; padding-left:10px; float:left">No.</div><div style="width:268px; float:left">Track</div><div style="width:203px; float:left">Artist</div><div style="width:127px; float:left">Duration
            </div>
    	</div>
		<?php $n=1; for($i=0; $i<$track_num_rows; $i++) { ?>
        <div style="height:<?php if(strlen($song[$i])>38 || strlen($artist[$i])>32) echo "50px"; else echo "25px"; ?>; font-size:14px; line-height:25px<?php if($n%2 != 0) echo "; background-color:#dcdddf"; ?>">
            <div style="width:32px; float:left; padding-left:12px"><?php echo $number[$i]; ?></div>
            <div style="width:268px; float:left"><?php echo $song[$i]; ?></div>
            <div style="width:203px; float:left"><?php echo $artist[$i]; ?></div>
            <div style="width:73px; float:left"><?php echo $length[$i]; ?></div>
            <?php if(!empty($buy[$i])) { ?><div style="width:44px; height:22px; float:right; padding-right:10px; padding-top:3px"><a href="<?php echo $buy[$i]; ?>" target="_blank"><img src="images/button-itunes-small.png" border="0"></a></div><?php } ?>
        </div>
        <?php $n++; } ?>
    </div>
    <div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">AUDIO <input name="Audio" type="text" style="width:575px; height:20px" value="<?php echo $audio; ?>" maxlength="500"></div>
    <div style="width:643px; padding-bottom:30px"><?php echo str_replace('&quot;', '"', $audio); ?></div>
    <div style="width:643px; height:23px; padding-top:15px; margin-right:331px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:33px">VIDEO <input name="Video" type="text" style="width:575px; height:20px" value="<?php echo $video; ?>" maxlength="500"></div>
    <div style="width:643px; padding-bottom:30px"><?php echo str_replace('&quot;', '"', $video); ?></div>
    </div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>