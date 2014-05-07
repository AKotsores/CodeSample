<?php
//make sure a user is logged in
if (empty($_COOKIE['username'])) {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//connect to database
include_once('php/conn.php');
//check if artist order is updated
if(isset( $_POST['order'] ) || isset( $_POST['order_x']) ) {
	//get order entered and id
	$order = mysqli_real_escape_string($dbc, trim($_POST['Order']));
	$record = $_POST['ID'];
	//if order is numeric update record
	if(is_numeric($order)) {
		$text = "UPDATE featured SET n='$order' WHERE artists_a_id='$record'";
		mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
	}
	//record in log
	$u_id = $_COOKIE['u_id'];
	$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'artists', $record, 'featured artist order updated', (NOW() + INTERVAL 3 HOUR))";
	mysqli_query($dbc, $text)
		or die('Error updating log: ' . mysqli_error($dbc));
	//close database connection
	mysqli_close($dbc);
	//refresh artists page
	header("Location: artists.php");
	exit;
}
//query all artists
$text = "SELECT featured.artists_a_id, artists.name, artists.photo, featured.n FROM artists, featured WHERE artists.a_id=featured.artists_a_id ORDER BY featured.n";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$total_num_results = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$a_id[] = $row['artists_a_id'];
	$name[] = strtoupper(stripslashes($row['name']));
	$photo[] = stripslashes($row['photo']);
	$order[] = $row['n'];
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

function verify()
{
	return confirm('Are you sure you want to remove this artist as a featured artist?')
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png','../images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-artists.png" width="974" height="102"></div>
</div>
<div style="width:974px; margin:0px auto; padding-top:28px">
	<div><img src="../images/browse_01.png"><img src="../images/browseO_02.png" width="169" height="60"><a href="all.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('All Artists','','../images/browseO_03.png',1)"><img src="../images/browse_03.png" alt="All Artists" name="All Artists" width="112" height="60" border="0"></a><img src="../images/browse_04.png" width="390" height="60"></div>
    <div style="height:30px"></div>
    <div style="width:974px; height:194px; margin-bottom:16px">
    	<?php $n=1; for ($i=0; $i<$total_num_results; $i++) {  
			if($n==1) { if($i>0 && $i%3==0) { ?></div><div style="width:974px; height:20px"></div><div style="width:974px; height:194px; margin-bottom:16px"><?php } ?>
        	<a href="profile.php?id=<?php echo $a_id[$i]; ?>"><div style="width:314px; height:59px; padding-top:135px; background-image:url(../artists/<?php echo $photo[$i]; ?>); background-repeat:no-repeat; background-size:314px 174px; float:left; margin-right:16px">
            	<div style="float:left; background-color:#D71F30; height:21px; line-height:21px; font-size:18px; font-family:'Oswald', sans-serif; color:#fff; padding:3px 6px"><?php echo $name[$i]; ?></div>
        		<br><br><form action="artists.php" method="post"><a href="deletefeature.php?id=<?php echo $a_id[$i]; ?>" onClick="return verify()"><img src="images/button-remove-featured.png" border="0" style="margin-top:3px"></a> <font size="-2">Order: </font><input name="Order" type="text" style="width:25px; height:15px" value="<?php echo $order[$i]; ?>" maxlength="2"><input name="ID" type="hidden" value="<?php echo $a_id[$i]; ?>"> <input type="image" src="images/button-update.png" border="0" alt="Submit" name="order" style="margin-top:3px"></form></div></a>
            <?php $n++; }
			else if($n==2) { ?>
            <a href="profile.php?id=<?php echo $a_id[$i]; ?>"><div style="width:314px; height:59px; padding-top:135px; background-image:url(../artists/<?php echo $photo[$i]; ?>); background-repeat:no-repeat; background-size:314px 174px; float:left">
                <div style="float:left; background-color:#D71F30; height:21px; line-height:21px; font-size:18px; font-family:'Oswald', sans-serif; color:#fff; padding:3px 6px"><?php echo $name[$i]; ?></div>
<br><br><form action="artists.php" method="post"><a href="deletefeature.php?id=<?php echo $a_id[$i]; ?>" onClick="return verify()"><img src="images/button-remove-featured.png" border="0" style="margin-top:3px"></a> <font size="-2">Order: </font><input name="Order" type="text" style="width:25px; height:15px" value="<?php echo $order[$i]; ?>" maxlength="2"><input name="ID" type="hidden" value="<?php echo $a_id[$i]; ?>"> <input type="image" src="images/button-update.png" border="0" alt="Submit" name="order" style="margin-top:3px"></form></div></a>            <?php $n++; }
			else if($n==3) { ?>
            <a href="profile.php?id=<?php echo $a_id[$i]; ?>"><div style="width:314px; height:59px; padding-top:135px; background-image:url(../artists/<?php echo $photo[$i]; ?>); background-repeat:no-repeat; background-size:314px 174px; float:right">
                <div style="float:left; background-color:#D71F30; height:21px; line-height:21px; font-size:18px; font-family:'Oswald', sans-serif; color:#fff; padding:3px 6px"><?php echo $name[$i]; ?></div>
<br><br><form action="artists.php" method="post"><a href="deletefeature.php?id=<?php echo $a_id[$i]; ?>" onClick="return verify()"><img src="images/button-remove-featured.png" border="0" style="margin-top:3px"></a> <font size="-2">Order: </font><input name="Order" type="text" style="width:25px; height:15px" value="<?php echo $order[$i]; ?>" maxlength="2"><input name="ID" type="hidden" value="<?php echo $a_id[$i]; ?>"> <input type="image" src="images/button-update.png" border="0" alt="Submit" name="order" style="margin-top:3px"></form></div></a>
        <?php $n=1; }
        } ?>
    </div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>