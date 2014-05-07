<?php
include_once('s.php');
//connect to database
include_once('php/conn.php');
//query compilations
$text = "SELECT c_id, cover FROM compilations ORDER BY released DESC";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of results
$total_num_results = mysqli_num_rows($query);
//put results in array
while ($row = mysqli_fetch_array($query)) {
	$c_id[] = $row['c_id'];
	$cover[] = stripslashes($row['cover']);
}
//close database connection
mysqli_close($dbc);
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau Entertainment | Compilations</title>
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
<body onLoad="MM_preloadImages('images/navO_24.png','images/navO_25.png','images/navO_26.png','images/navO_27.png','images/navO_28.png','images/navO_29.png','images/browseO_02.png','images/browseO_03.png')">
<?php include_once('header.php'); ?>
<div style="background-image:url('images/background-crowd.png'); background-repeat:no-repeat; background-position:center bottom">
	<div style="background-color:#2E2D74; height:102px">
		<div style="width:974px; height:102px; margin:0 auto"><img src="images/subhead-compilations.png" width="974" height="102"></div>
	</div>
	<div style="width:974px; margin:0px auto; padding-top:28px; padding-bottom:20px">
		<div style="height:30px"></div>
		<div style="width:974px; height:308px; margin-bottom:25px">
			<?php $n=1; for ($i=0; $i<$total_num_results; $i++) { 
				if($n==1) { if($i>0 && $i%3==0) { ?></div><div style="width:974px; height:308px; margin-bottom:25px"><?php } ?>
				<div style="width:308px; height:308px; float:left; margin-right:25px">
					<a href="details.php?id=<?php echo $c_id[$i]; ?>"><img src="covers/<?php echo $cover[$i]; ?>" width="308" height="308" border="0"></a>
				</div>
				<?php $n++; }
				else if($n==2) { ?>
				<div style="width:308px; height:308px; float:left">
					<a href="details.php?id=<?php echo $c_id[$i]; ?>"><img src="covers/<?php echo $cover[$i]; ?>" width="308" height="308" border="0"></a>
				</div>
				<?php $n++; }
				else if($n==3) { ?>
				<div style="width:308px; height:308px; float:right">
					<a href="details.php?id=<?php echo $c_id[$i]; ?>"><img src="covers/<?php echo $cover[$i]; ?>" width="308" height="308" border="0"></a>
				</div>
				<?php $n=1; }
			} ?>
		</div>
	</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>