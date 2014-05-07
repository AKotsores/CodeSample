<?php
//make sure a user is logged in
if (empty($_COOKIE['username']) || $_COOKIE['level'] != 'Admin') {
	//redirect to login page
	header("Location: index.php");
	exit;
}
//connect to database
include('php/conn.php');
//get users last login
$text = "SELECT users.username, MAX(logs.time_stamp) FROM users INNER JOIN logs ON users.u_id=logs.user_id WHERE logs.user_action='user login' GROUP BY username ORDER BY logs.time_stamp";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
while ($row = mysqli_fetch_array($query)) {
	$username[] = stripslashes($row['username']);
	$time[] = date("F d, Y - g:i a", strtotime($row['MAX(logs.time_stamp)']));
}
//get number of rows
$total_num_results = mysqli_num_rows($query);
//get actions from last 7 days
$text = "SELECT users.username, logs.table_record, logs.user_action, logs.time_stamp FROM users, logs WHERE users.u_id=logs.user_id AND (logs.user_action!='user login' AND logs.user_action!='user logout') AND logs.time_stamp>=(CURRENT_TIMESTAMP - INTERVAL 14 DAY) ORDER BY logs.time_stamp DESC";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
while ($row = mysqli_fetch_array($query)) {
	$username2[] = stripslashes($row['username']);
	$record[] = $row['table_record'];
	$action[] = stripslashes($row['user_action']);
	$time2[] = date("F d, Y - g:i a", strtotime($row['time_stamp']));
}
//get number of rows
$total_num_actions = mysqli_num_rows($query);

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
	return confirm('Do you really want to delete this user?')
}
</script>
</head>
<body onLoad="MM_preloadImages('../images/navO_24.png','../images/navO_25.png','../images/navO_26.png','../images/navO_27.png','../images/navO_28.png','../images/navO_29.png','../images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-color:#2E2D74; height:102px">
	<div style="width:974px; height:102px; margin:0 auto"><img src="images/subhead-logs.png" width="974" height="102"></div>
</div>
<div style="width:974px; height:<?php echo ($total_num_actions*25)+140; ?>px; margin:0px auto; padding-top:10px">
	<div style="margin-bottom:10px"><a href="javascript:history.back(-1);"><img src="../images/button-back.png" border="0" onMouseOver="this.src='../images/button-backO.png'" onMouseOut="this.src='../images/button-back.png'"></a></div>
    <div style="float:left">
    	<div style="width:350px; height:23px; padding-top:15px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:15px">LAST LOGIN</div>
        <div style="width:350px; height:30px">
            <div style="font-size:14px; font-weight:bold">
                <div style="width:150px; float:left">Username</div>
                <div style="width:200px; float:left">Timestamp</div>
            </div>
        </div>
        <?php $n=1; for($i=0; $i<$total_num_results; $i++) { ?>
        <div style="width:350px; height:25px; font-size:14px; line-height:25px<?php if($n%2 != 0) echo "; background-color:#dcdddf"; ?>">
            <div style="width:146px; float:left; padding-left:4px"><?php echo $username[$i]; ?></div>
            <div style="width:196px; float:left; padding-left:4px"><?php echo $time[$i]; ?></div>
        </div>
        <?php $n++; } ?>
    </div>
    <div style="float:right; height:<?php echo $total_num_actions*25; ?>px">
    	<div style="width:600px; height:23px; padding-top:15px; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px; margin-bottom:15px">LOGS (LAST 14 DAYS)</div>
        <div style="width:600px; height:30px">
            <div style="font-size:14px; font-weight:bold">
                <div style="width:135px; float:left">Username</div>
                <div style="width:265px; float:left">Action</div>
                <div style="width:200px; float:left">Timestamp</div>
            </div>
        </div>
        <?php $n=1; for($i=0; $i<$total_num_actions; $i++) { ?>
        <div style="width:600px; height:25px; font-size:14px; line-height:25px<?php if($n%2 != 0) echo "; background-color:#dcdddf"; ?>">
            <div style="width:131px; float:left; padding-left:4px"><?php echo $username2[$i]; ?></div>
            <div style="width:261px; float:left; padding-left:4px">
			<?php
            if($action[$i]=='release record updated' || $action[$i]=='new release added') echo '<a href="editsingle.php?id=' . $record[$i] . '">' . $action[$i] . '</a>'; 
			else if($action[$i]=='artist profile updated' || $action[$i]=='new artist added') echo '<a href="profile.php?id=' . $record[$i] . '">' . $action[$i] . '</a>'; 
			else if($action[$i]=='featured release order updated') echo '<a href="releases.php">' . $action[$i] . '</a>'; 
			else if($action[$i]=='banner record updated') echo '<a href="editbanners.php">' . $action[$i] . '</a>'; 
			else echo $action[$i];
			?></div>
            <div style="width:196px; float:left; padding-left:4px"><?php echo $time2[$i]; ?></div>
        </div>
        <?php $n++; } ?>
    </div>
</div>
<div style="clear:both"></div>
<?php include_once('footer.php'); ?>
</body>
</html>