<?php
//make sure a user is logged in
if (empty($_COOKIE['username'])) {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//get id from URL
$id = $_REQUEST['id'];
if(!empty($id) && is_numeric($id)) {
	//check if new item was added
	if(isset( $_POST['submit'] ) || isset( $_POST['submit_x']) ) {
		//connect to database
		include_once('php/conn.php');
		//get form data
		$track = mysqli_real_escape_string($dbc, trim($_POST['Number']));
		$song = mysqli_real_escape_string($dbc, trim($_POST['Song']));
		$artists = mysqli_real_escape_string($dbc, trim($_POST['Artist']));
		$length = mysqli_real_escape_string($dbc, trim($_POST['Length']));
		$buy = mysqli_real_escape_string($dbc, trim($_POST['iTunes']));
		//put in new record
		$text = "INSERT INTO tracklist (number, track, artist, duration, itunes, compilations_c_id) VALUES ('$track', '$song', '$artists', '$length', '$buy', '$id')";
		$query = mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
		//get catalog ID that was just added
		$text = "SELECT t_id FROM tracklist ORDER BY t_id DESC LIMIT 1";
		$query = mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
		while ($row = mysqli_fetch_array($query)) {
			$t_id = $row['t_id'];
		}
		//record in log
		$u_id = $_COOKIE['u_id'];
		$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'tracklist', $t_id, 'tracklist record added', (NOW() + INTERVAL 3 HOUR))";
		mysqli_query($dbc, $text)
			or die('Error updating log: ' . mysqli_error($dbc));
		//close database connection
		mysqli_close($dbc);
		//refresh
		header("Location: editplaylist.php?id=" . $id);
	}
	//connect to database
	include_once('php/conn.php');
	//query catalog
	$text = "SELECT * FROM tracklist WHERE compilations_c_id=$id ORDER BY number";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//get number of results
	$total_num_results = mysqli_num_rows($query);
	//put results in array
	while ($row = mysqli_fetch_array($query)) {
		$t_id[] = $row['t_id'];
		$track[] = $row['number'];
		$song[] = stripslashes($row['track']);
		$artist[] = stripslashes($row['artist']);
		$duration[] = stripslashes($row['duration']);
		$buy[] = stripslashes($row['iTunes']);
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

function verify()
{
	return confirm('Do you really want to delete this track?')
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-compilations.png" width="974" height="102"></div>
</div>
<div style="width:974px; margin:0px auto">
	<div style="margin-bottom:10px; margin-top:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a></div>
	<div style="width:974px; height:30px">
		<div style="font-size:14px; font-weight:bold">
    		<div style="width:35px; padding-left:10px; float:left">No.</div><div style="width:350px; float:left">Track</div><div style="width:315px; float:left">Artist</div><div style="width:100px; float:left">Duration</div><div style="width:130px; float:left">iTunes Link</div>
    	</div>
    </div>
    <?php $n=1; for($i=0; $i<$total_num_results; $i++) { ?>
    <div style="width:900px; height:25px; font-size:14px; line-height:25px<?php if($n%2 != 0) echo "; background-color:#dcdddf"; ?>">
    	<div style="width:35px; float:left; margin-right:6px; padding-left:4px"><?php echo $track[$i]; ?></div>
      	<div style="width:340px; float:left; margin-right:6px; padding-left:4px"><?php echo $song[$i]; ?></div>
   	  	<div style="width:309px; float:left; padding-left:6px"><?php echo $artist[$i]; ?></div>
        <div style="width:45px; float:left; margin-right:6px; padding-left:4px"><?php echo $duration[$i]; ?></div>
        <div style="width:44px; float:left; padding-left:4px; margin-left:50px"><a href="<?php echo $buy[$i]; ?>" target="_blank"><img src="../images/button-itunes-small.png" border="0"></a></div>
      	<div style="float:right"><a href="edittrack.php?id=<?php echo $t_id[$i]; ?>&c_id=<?php echo $id; ?>"><img src="images/button-pencil.png" border="0"></a> <a href="deletetrack.php?id=<?php echo $t_id[$i]; ?>&c_id=<?php echo $id; ?>" onClick="return verify()"><img src="images/button-x.png" border="0"></a></div>
    </div>
    <?php $n++; } ?>
    <div style="width:974px; height:25px; font-size:14px; line-height:25px">
   	  <form action="editplaylist.php?id=<?php echo $id; ?>" method="post">
      	<div style="width:35px; float:left; margin-right:6px; padding-left:4px"><input name="Number" type="text" style="width:35px; height:20px" maxlength="2"></div>
    	<div style="width:340px; float:left; margin-right:6px; padding-left:4px"><input name="Song" type="text" style="width:340px; height:20px" maxlength="45"></div>
        <div style="width:309px; float:left; margin-right:6px"><input name="Artist" type="text" style="width:309px; height:20px" maxlength="45"></div>
        <div style="width:45px; float:left; margin-right:6px; padding-left:4px"><input name="Length" type="text" style="width:45px; height:20px" maxlength="5"></div>
      	<div style="width:130px; float:left; padding-left:4px"><input name="iTunes" type="text" style="width:130px; height:20px" maxlength="200"></div>
        <div style="float:left; padding-top:2px; margin-left:10px"><input type="image" src="images/button-plus.png" border="0" alt="Submit" name="submit"></div>
      </form>
    </div>
    <div style="height:15px"></div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>