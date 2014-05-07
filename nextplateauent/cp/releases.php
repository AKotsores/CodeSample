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
		$text = "UPDATE singles SET n='$order' WHERE s_id='$record'";
		mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
	}
	//record in log
	$u_id = $_COOKIE['u_id'];
	$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'singles', $record, 'featured release order updated', (NOW() + INTERVAL 3 HOUR))";
	mysqli_query($dbc, $text)
		or die('Error updating log: ' . mysqli_error($dbc));
	//close database connection
	mysqli_close($dbc);
	//refresh artists page
	header("Location: releases.php");
	exit;
}
//query featured singles
$text = "SELECT s_id, cover, n FROM singles WHERE featured=1 ORDER BY n, released DESC";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$total_num_results = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$s_id[] = $row['s_id'];
	$cover[] = stripslashes($row['cover']);
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
	return confirm('Do you really want to delete this release?')
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png','../images/browseO_02.png','../images/a_browse_03.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-releases.png"></div>
</div>
<div style="width:974px; margin:0px auto; padding-top:28px">
	<div><img src="../images/a_browse_01.png"><img src="../images/a_browse_02.png" width="165" height="60"><a href="allreleases.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('AllReleases','','../images/a_browse_03.png',1)"><img src="../images/a_browseO_03.png" alt="All Releases" name="AllReleases" width="111" height="60" border="0"></a><img src="../images/a_browse_04.png" width="391" height="60"></div>
<div style="height:30px"></div>
    <div style="width:974px; height:<?php echo ceil($total_num_results/4)*290; ?>px">
        <div style="width:974px; height:220px; padding-bottom:20px">
            <?php $n=1; for ($i=0; $i<$total_num_results; $i++) { 
                if($n==1) { if($i>0 && $n==1) { ?></div><div style="width:974px; height:220px; padding-bottom:20px"><?php } ?>
                <div style="padding-top:200px; margin-right:58px; width:200px; height:70px; background-image:url(../covers/<?php echo $cover[$i]; ?>); background-repeat:no-repeat; background-size:200px 200px; float:left">
                    <a href="editsingle.php?id=<?php echo $s_id[$i]; ?>"><img src="images/button-edit.png" width="70" height="20" border="0"></a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="deletesingle.php?id=<?php echo $s_id[$i]; ?>" onClick="return verify()"><img src="images/button-delete.png" border="0"></a><br>
                    <form action="releases.php" method="post"><font size="-2">Order: </font><input name="Order" type="text" style="width:25px; height:15px" value="<?php echo $order[$i]; ?>" maxlength="2"><input name="ID" type="hidden" value="<?php echo $s_id[$i]; ?>"> <input type="image" src="images/button-update.png" border="0" alt="Submit" name="order" style="margin-top:3px"></form>
          		</div>
                <?php $n++; }
                else if($n==2) { ?>
                <div style="padding-top:200px; margin-right:58px; width:200px; height:70px; background-image:url(../covers/<?php echo $cover[$i]; ?>); background-repeat:no-repeat; background-size:200px 200px; float:left">
                    <a href="editsingle.php?id=<?php echo $s_id[$i]; ?>"><img src="images/button-edit.png" width="70" height="20" border="0"></a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="deletesingle.php?id=<?php echo $s_id[$i]; ?>" onClick="return verify()"><img src="images/button-delete.png" border="0"></a><br>
                    <form action="releases.php" method="post"><font size="-2">Order: </font><input name="Order" type="text" style="width:25px; height:15px" value="<?php echo $order[$i]; ?>" maxlength="2"><input name="ID" type="hidden" value="<?php echo $s_id[$i]; ?>"> <input type="image" src="images/button-update.png" border="0" alt="Submit" name="order" style="margin-top:3px"></form>
                </div>
                <?php $n++; }
                else if($n==3) { ?>
                <div style="padding-top:200px; margin-right:58px; width:200px; height:70px; background-image:url(../covers/<?php echo $cover[$i]; ?>); background-repeat:no-repeat; background-size:200px 200px; float:left">
                    <a href="editsingle.php?id=<?php echo $s_id[$i]; ?>"><img src="images/button-edit.png" width="70" height="20" border="0"></a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="deletesingle.php?id=<?php echo $s_id[$i]; ?>" onClick="return verify()"><img src="images/button-delete.png" border="0"></a><br>
                    <form action="releases.php" method="post"><font size="-2">Order: </font><input name="Order" type="text" style="width:25px; height:15px" value="<?php echo $order[$i]; ?>" maxlength="2"><input name="ID" type="hidden" value="<?php echo $s_id[$i]; ?>"> <input type="image" src="images/button-update.png" border="0" alt="Submit" name="order" style="margin-top:3px"></form>
                </div>
                <?php $n++; }
                else if($n==4) { ?>
              <div style="padding-top:200px; width:200px; height:70px; background-image:url(../covers/<?php echo $cover[$i]; ?>); background-repeat:no-repeat; background-size:200px 200px; float:right">
                    <a href="editsingle.php?id=<?php echo $s_id[$i]; ?>"><img src="images/button-edit.png" width="70" height="20" border="0"></a> &nbsp;&nbsp;&nbsp;&nbsp;<a href="deletesingle.php?id=<?php echo $s_id[$i]; ?>" onClick="return verify()"><img src="images/button-delete.png" border="0"></a><br>
                    <form action="releases.php" method="post"><font size="-2">Order: </font><input name="Order" type="text" style="width:25px; height:15px" value="<?php echo $order[$i]; ?>" maxlength="2"><input name="ID" type="hidden" value="<?php echo $s_id[$i]; ?>"> <input type="image" src="images/button-update.png" border="0" alt="Submit" name="order" style="margin-top:3px"></form>
                </div>
                <?php $n=1; }
            } ?>
        </div>
    </div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>