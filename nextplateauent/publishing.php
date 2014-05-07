<?php
include_once('s.php');
//connect to database
include_once('php/conn.php');
//query catalog
$text = "SELECT * FROM catalog ORDER BY song";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$total_num_results = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$song[] = stripslashes($row['song']);
	$artist[] = stripslashes($row['artist']);
	$writers[] = stripslashes($row['writers']);
	$link[] = $row['link'];
}
//close database connection
mysqli_close($dbc);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau Entertainment | Publishing</title>
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
	<div style="background-color:#2E2D74; height:102px">
		<div style="width:974px; height:102px; margin:0 auto"><img src="images/subhead-publishing.png" width="974" height="102"></div>
	</div>
	<div style="width:974px; margin:0px auto">
		<div style="padding-top:25px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B; width:646px; float:left">EDDIE O SONGS INC</div>
		<div style="padding-top:25px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B; width:313px; float:right">REQUESTS</div>
		<div style="padding-top:30px; height:101px; padding-bottom:45px; width:165px; float:left"><img src="images/EoS.png" width="165" height="101"></div>
		<div style="padding-top:30px; height:101px; padding-bottom:45px; padding-left:18px; width:463px; line-height:18px; font-size:14px; float:left">Eddie O Songs Inc is the music publishing arm of Next Plateau Entertainment, Inc., which is active in discovering and developing song writers from all over the World.</div>
		<div style="padding-top:30px; height:101px; padding-bottom:45px; width:313px; line-height:18px; font-size:14px; float:right">To request information for mechanical licensing, synch licensing or other publishing use, please <a href="mailto:eddieosongs@nextplateauent.com">Contact Us</a>.</div>
		<div style="padding-top:43px"><img src="images/tab-catalog.png"></div>
		<div style="width:974px; height:60px">
			<div style="padding-top:33px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B; width:256px; float:left; margin-right:16px">SONG</div>
			<div style="padding-top:33px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B; width:276px; float:left; margin-right:16px">ARTIST</div>
			<div style="padding-top:33px; height:25px; border-bottom:#F00 solid 2px; font-size:18px; font-family:'Oswald', sans-serif; color:#58595B; width:410px; float:left">WRITERS</div>
		</div>
		<div style="height:15px"></div>
		<?php $n=1; for($i=0; $i<$total_num_results; $i++) { ?>
		<div style="width:974px; height:<?php if(strlen($song[$i])>43 || strlen($artist[$i])>40 || strlen($writers[$i])>57) echo "50px"; else echo "25px"; ?>; font-size:14px; line-height:25px<?php if($n%2 != 0) echo "; background-color:#dcdddf"; ?>">
			<div style="width:250px; float:left; margin-right:16px; padding-left:6px"><?php if(!empty($link[$i])) { ?><a href="profile.php?id=<?php echo $link[$i]; ?>"><?php } echo $song[$i]; if(!empty($link[$i])) echo "</a>"; ?></div>
			<div style="width:270px; float:left; margin-right:16px; padding-left:6px"><?php echo $artist[$i]; ?></div>
			<div style="width:400px; float:left; padding-left:6px"><?php echo $writers[$i]; ?></div>
		</div>
		<?php $n++; } ?>
		<div style="height:15px"></div>
	</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>