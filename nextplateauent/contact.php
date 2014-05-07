<?php
include_once('s.php');
$name = "Name";
$email = "Email";
$body = "Questions, Comments, Suggestions...";
$output_form = true;
//check if form was submitted
if(isset( $_POST['submit'] ) || isset( $_POST['submit_x']) ) {
	//get form fields
	$output_form = false;
	$name = $_POST['Name'];
	$email = $_POST['Email'];
	$body = $_POST['Message'];
	//make sure fields are not empty
	if(empty($name) || empty($email) || empty($body)) {
		$output_form = true;
		$status = "Please fill in all fields.";
	}
	//validate email
	if(!$output_form) {
		include('php/emailVal.php');
	}
	//send message
	if(!$output_form) {
		$msg = "Contact form submission from " . $name . " <" . $email . ">
		
Message:
" . $body;
		$header = "Reply-To: $name <$email>\r\n";
		$header .= "Return-Path: Next Plateau <info@nextplateauent.com>\r\n";
		$header .= "From: $name <$email>\r\n";
		$header .= "Organization: Next Plateau Entertainment\r\n";
		$header .= "Content-Type: text/plain\r\n";
		$header .= "X-Mailer: PHP/" . phpversion();
		$subject = "Contact form submission on nextplateauent.com";
		//send to Next Plateau
		mail('info@nextplateauent.com', $subject, $msg, $header);
	}
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Next Plateau Entertainment | Contact</title>
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

function clearField(thisfield, defaulttext) {
	if (thisfield.value == defaulttext) {
		thisfield.value = "";
	}
}
function recallField(thisfield, defaulttext) {
	if (thisfield.value == "") {
		thisfield.value = defaulttext;
	}
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
		<div style="width:974px; height:102px; margin:0 auto"><img src="images/subhead-contact.png" width="974" height="102"></div>
	</div>
	<div style="height:24px"></div>
	<div style="width:974px; height:530px; margin:0px auto">
		<div style="width:647px; height:23px; padding-top:20px; float:left; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px"><a name="form"></a>CONTACT FORM</div>
		<div style="width:313px; height:23px; padding-top:20px; float:right; color:#58595B; border-bottom:#D71F30 solid 2px; font-family:'Oswald', sans-serif; line-height:17px; font-size:18px">NEXT PLATEAU</div>
		<div style="width:647px; height:455px; padding-top:30px; float:left; line-height:18px; font-size:14px">
		Please fill out the form below to send your comments, suggestions and requests.<br><br>
		<b>Demo Policy</b><br>
		Next Plateau does not accept unsolicited material.
		<?php if($output_form) { ?>
		<form action="contact.php#form" method="post">
		<div style="height:34px"></div>
		<input name="Name" type="text" style="width:456px; height:31px; border:#A7A9AC 1px solid; color:#A7A9AC; font-family:'Karla', sans-serif; font-size:14px; padding-left:9px; padding-right:9px" value="<?php echo $name; ?>" onClick="clearField(this, '<?php echo $name; ?>')" onBlur="recallField(this, '<?php echo $name; ?>')">
		<div style="height:25px"></div>
		<input name="Email" type="text" style="width:456px; height:31px; border:#A7A9AC 1px solid; color:#A7A9AC; font-family:'Karla', sans-serif; font-size:14px; padding-left:9px; padding-right:9px" value="<?php echo $email; ?>" onClick="clearField(this, '<?php echo $email; ?>')" onBlur="recallField(this, '<?php echo $email; ?>')">
		<div style="height:25px"></div>
		<textarea name="Message" style="width:627px; height:107px; border:#A7A9AC 1px solid; color:#A7A9AC; font-family:'Karla', sans-serif; font-size:14px; padding:9px" onClick="clearField(this, '<?php echo $body; ?>')" onBlur="recallField(this, '<?php echo $body; ?>')"><?php echo $body; ?></textarea>
		<div style="height:25px"></div>
		<input type="image" src="images/button-submit.png" border="0" alt="Submit" name="submit" onMouseOver="javascript:this.src='images/button-submitO.png';" onMouseOut="javascript:this.src='images/button-submit.png';">
		<div style="height:25px; font-size:12px; color:#D71F30; font-weight:bold"><?php if(!empty($status)) echo "*" . $status; ?></div>
		</form>
		<?php } else { ?>
		<div style="text-align:center; font-size:16px; padding-top:75px; padding-bottom:25px; font-weight:bold">Your form has been submitted. You will be contacted shortly. Thank you.</div>
		<?php } ?>
	   </div>
		<div style="width:313px; height:455px; padding-top:30px; float:right; line-height:18px; font-size:14px">
		35 Worth Street, 4<sup>th</sup> Floor<br>
		New York, NY 10013<br>
		<a href="http://goo.gl/maps/m9peM" target="_blank">Map It</a><br>
		+1 212 243.6103 phone<br>
		+1 212 675.4441 fax<br><br>
		<b>Mechanical Licensing Requests</b><br>
		<a href="mailto:eddieosongs@nextplateauent.com?subject=Mechanical Licensing Requests">eddieosongs@nextplateauent.com</a><br><br>
		<b>All Other Licensing Requests</b><br>
		<a href="mailto:ba@nextplateauent.com?subject=Other Licensing Requests">BA@nextplateauent.com</a><br><br>
		<b>Royalties &amp; Payments</b><br>
		<a href="mailto:royalties@nextplateauent.com?subject=Royalties and Payments">royalties@nextplateauent.com</a><br><br>
		<b>Press Inquiries + General Info</b><br>
		<a href="mailto:info@nextplateauent.com?subject=Press Inquiries + General Info">info@nextplateauent.com</a>
		</div>
	</div>
	<div style="height:355px; margin-bottom:30px; padding-bottom:20px">
		<div style="width:974px; height:355px; margin:0 auto"><iframe width="974" height="355" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?q=35+Worth+Street,+New+York,+NY+10013&amp;hl=en&amp;sll=39.739318,-89.266507&amp;sspn=12.948784,28.54248&amp;hnear=35+Worth+St,+New+York,+10013&amp;t=m&amp;ie=UTF8&amp;hq=&amp;ll=40.721665,-74.006481&amp;spn=0.011546,0.041757&amp;z=15&amp;iwloc=A&amp;output=embed"></iframe></div>
	</div>
</div>
<?php include_once('footer.php'); ?>
</body>
</html>