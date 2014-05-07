<?php
//make sure a user is logged in
if (empty($_COOKIE['username'])) {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//get id from url
$id = $_REQUEST['id'];
//check if record was updated
if(isset( $_POST['submit'] ) || isset( $_POST['submit_x']) ) {
	//connect to database
	include_once('php/conn.php');
	//get form data
	$song = mysqli_real_escape_string($dbc, trim($_POST['Song']));
	$artists = mysqli_real_escape_string($dbc, trim($_POST['Artist']));
	$writers = mysqli_real_escape_string($dbc, trim($_POST['Writers']));
	$link = $_POST['a1'];
	//update record
	$text = "UPDATE catalog SET song='$song', artist='$artists', writers='$writers', link='$link' WHERE cat_id='$id'";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//record in log
	$u_id = $_COOKIE['u_id'];
	$text = "INSERT INTO logs (user_id, npe_table, table_record, user_action, time_stamp) VALUES ($u_id, 'catalog', $id, 'edit made', (NOW() + INTERVAL 3 HOUR))";
	mysqli_query($dbc, $text)
		or die('Error updating log: ' . mysqli_error($dbc));
	//close database connection
	mysqli_close($dbc);
	//refresh
	header("Location: publishing.php");
}
//make sure id is not null and a number
if(!empty($id) && is_numeric($id)) {
	//connect to database
	include_once('php/conn.php');
	//query catalog
	$text = "SELECT * FROM catalog WHERE cat_id=$id";
	$query = mysqli_query($dbc, $text)
		or die("Error executing query: " . mysqli_error($dbc));
	//get number of results
	$total_num_results = mysqli_num_rows($query);
	if($total_num_results>0) {
		//put results in array
		while ($row = mysqli_fetch_array($query)) {
			$cat_id = $row['cat_id'];
			$song = stripslashes($row['song']);
			$artist = stripslashes($row['artist']);
			$writers = stripslashes($row['writers']);
			$a1 = $row['link'];
		}
		//close database connection
		mysqli_close($dbc);
	}
	else
		header("Location: publishing.php");
}
else {
	header("Location: publishing.php");
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
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="../images/subhead-publishing.png" width="974" height="102"></div>
</div>
<div style="width:974px; margin:0px auto; margin-top:10px">
  <div style="margin-bottom:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a></div>
<div><img src="../images/tab-catalog.png" width="974" height="60"></div>
    <div style="width:974px; height:60px">
        <div style="padding-top:33px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B; width:256px; float:left; margin-right:16px">SONG</div>
        <div style="padding-top:33px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B; width:276px; float:left; margin-right:16px">ARTIST</div>
        <div style="padding-top:33px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B; width:410px; float:left">WRITERS</div>
    </div>
    <div style="height:15px"></div>
    <div style="width:974px; height:25px; font-size:14px; line-height:25px">
   	  <form action="editcatalog.php?id=<?php echo $id; ?>" method="post">
    	<div style="width:250px; float:left; margin-right:16px; padding-left:6px"><input name="Song" type="text" style="width:250px; height:20px" value="<?php echo $song; ?>" maxlength="250"></div>
        <div style="width:270px; float:left; margin-right:16px; padding-left:6px"><input name="Artist" type="text" style="width:270px; height:20px" value="<?php echo $artist; ?>" maxlength="250"></div>
      	<div style="width:380px; float:left; padding-left:6px"><input name="Writers" type="text" style="width:380px; height:20px" value="<?php echo $writers; ?>" maxlength="250"></div>
        <div style="float:right; padding-top:2px"><input type="image" src="images/button-plus.png" border="0" alt="Submit" name="submit"></div>
		<div>Link to Artist: <?php include_once('php/artistmenu.php'); ?></div>
      </form>
    </div>
    <div style="height:15px"></div>
</div>
<div style="clear:both"></div>
<?php include_once('footer.php'); ?>
</body>
</html>