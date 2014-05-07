<?php
//make sure a user is logged in
if (empty($_COOKIE['username'])) {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//connect to database
include_once('php/conn.php');
require_once('php/sysvars.php');
//check if form was submitted
if(isset( $_POST['add'] ) || isset( $_POST['add_x']) ) {
	$banner = str_replace(" ", "", $_FILES['Banner'] ['name']);
	$a_link = mysqli_real_escape_string($dbc, trim($_POST['URL']));
	$a_order = mysqli_real_escape_string($dbc, trim($_POST['Order']));
	if(!empty($banner) && (is_numeric($a_order) || empty($a_order))) {
		//move banner to folder
		$target = GW_UPLOADPATH_BANNER . $banner;
		move_uploaded_file($_FILES['Banner'] ['tmp_name'], $target)
			or die("Error moving flyer");
		//add record in database
		$text = "INSERT INTO banners (name, link, n) VALUES ('$banner', '$a_link', '$a_order')";
		mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
			
		//get banner ID that was just added
		$text = "SELECT b_id FROM banners ORDER BY b_id DESC LIMIT 1";
		$query = mysqli_query($dbc, $text)
			or die("Error executing query: " . mysqli_error($dbc));
		while ($row = mysqli_fetch_array($query)) {
			$b_id = $row['b_id'];
		}
		//record in log
		$u_id = $_COOKIE['u_id'];
		$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'banners', $b_id, 'new banner added', (NOW() + INTERVAL 3 HOUR))";
		mysqli_query($dbc, $text)
			or die('Error updating log: ' . mysqli_error($dbc));
		//close database connection
		mysqli_close($dbc);
		//refresh page
		header('Location: editbanners.php');
	}
	else
		$status = "Check that order is numeric and file is chosen";
}
if(isset( $_POST['submit'] ) || isset( $_POST['submit_x']) ) {
	//put results in variables
	$id = $_POST['ID'];
	$link = mysqli_real_escape_string($dbc, trim($_POST['URL']));
	$n = mysqli_real_escape_string($dbc, trim($_POST['Order']));
	
	$text = "UPDATE banners SET link='$link', n='$n' WHERE b_id=$id";
	mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//record in log
	$u_id = $_COOKIE['u_id'];
	$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'banners', $id, 'banner record updated', (NOW() + INTERVAL 3 HOUR))";
	mysqli_query($dbc, $text)
		or die('Error updating log: ' . mysqli_error($dbc));
	//close database connection
	mysqli_close($dbc);
	//refresh page
	header('Location: editbanners.php');
}
//get banner details
$text = "SELECT * FROM banners ORDER BY n";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
while ($row = mysqli_fetch_array($query)) {
	$b_id[] = $row['b_id'];
	$b_name[] = stripslashes($row['name']);
	$b_link[] = stripslashes($row['link']);
	$order[] = $row['n'];
}
//get number of records returned
$total_num_results = mysqli_num_rows($query);
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
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png','../images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-banners.png"></div>
</div>
<div style="width:974px; height:<?php echo (ceil($total_num_results/2)*280)+110; ?>px; margin:0px auto; padding-top:10px; font-size:12px">
	<div style="margin-bottom:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a></div>
	<div style="margin-bottom:15px"><font size="+1">Add Banner:</font> <font size="-2" color="#D71F30">*Banner size is 974 pixels wide and 355 pixels high</font><br>
    <form action="#" method="post" enctype="multipart/form-data">
    File: <input name="Banner" type="file"> Link: <input name="URL" type="text" value="<?php echo $a_link; ?>" maxlength="75" style="width:300px; height:18px; font-size:12px"> Order: <input name="Order" type="text" style="width:20px; height:18px; font-size:12px" value="<?php echo $a_order; ?>" maxlength="2"> <input type="image" src="images/button-add.png" border="0" alt="Submit" name="add"> <?php if(!empty($status)) echo "<font color=#D71F30>" . $status . "</font>"; ?>
    </form>
    </div>
	<?php $n=1; for($i=0; $i<$total_num_results; $i++) { ?>
    <div style="width:477px; height:255px; float:<?php if($n%2==0) echo "right"; else echo "left"; ?>; margin-bottom:20px"><font size="+1">Banner <?php echo $i+1; ?></font><br>
    <img src="../banners/<?php echo $b_name[$i]; ?>" width="477" height="196">
    	<div style="float:left"><a href="deletebanner.php?id=<?php echo $b_id[$i]; ?>"><img src="images/button-delete.png" border="0"></a></div>
        <div style="float:right">
        	<form action="#" method="post">
            Link: <input name="URL" type="text" value="<?php echo $b_link[$i]; ?>" maxlength="75" style="width:225px; height:18px; font-size:12px"> Order: <input name="Order" type="text" style="width:20px; height:18px; font-size:12px" value="<?php echo $order[$i]; ?>" maxlength="2"><input name="ID" type="hidden" value="<?php echo $b_id[$i]; ?>"><input type="image" src="images/button-update.png" border="0" alt="Submit" name="submit">
            </form>
        </div>
  </div>
    <?php $n++; } ?>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>