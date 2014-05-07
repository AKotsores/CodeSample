<?php
$output_form = true;
$email = "Enter your email here to receive news and more!";
//check if signup was submitted
if(isset( $_POST['mailchimp'] ) || isset( $_POST['mailchimp_x']) ) {
	$output_form = false;
	$stat = "";
	$email = $_POST['Email'];
	if(empty($email) || $email == "Enter your email here to receive news and more!") {
		$stat = "Please enter an email address";
		$output_form = true;
	}
	else
		include('php/emailVal2.php');
	if(!$output_form) {
		require_once '../inc/MCAPI.class.php';
		require_once '../inc/config.inc.php';
		$api = new MCAPI($apikey);
		$retval = $api -> listSubscribe($listId, $email);
		if ($api->errorCode){
			$stat = "Unable to load listSubscribe()!\n";
			$stat .= "\tCode=".$api->errorCode."\n";
			$stat .= "\tMsg=".$api->errorMessage."\n";
		} 
		else {
			$stat = "Welcome to our mailing list - look for the confirmation email!\n";
		}
	}
}
?>
<script type="text/javascript">
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
</script>
<div style="background-color:#E6E7E8; height:187px; border-bottom:#D71F30 solid 11px">
	<div style="width:974px; height:187px; margin:0 auto">
		<div style="padding-top:23px; width:220px; height:19px; border-bottom:#D71F30 solid 2px; float:left; color:#58595B; font-family:'Oswald', sans-serif; line-height:17px; font-size:14px">NEXT PLATEAU</div>
   		<div style="width:31px; height:44px; float:left"></div>
    	<div style="padding-top:23px; width:220px; height:19px; border-bottom:#D71F30 solid 2px; float:left; color:#58595B; font-family:'Oswald', sans-serif; line-height:17px; font-size:14px">SITE MAP</div>
        <div style="width:26px; height:44px; float:left"></div>
    	<div style="padding-top:23px; width:477px; height:19px; border-bottom:#D71F30 solid 2px; float:right; color:#58595B; font-family:'Oswald', sans-serif; line-height:17px; font-size:14px">CONNECT WITH NEXT PLATEAU<a name="chimp"></a></div>
    	<div style="padding-top:10px; width:220px; height:126px; float:left; font-size:14px; line-height:17px">35 Worth Street, 4th Floor<br>New York, NY 10013<br><a href="http://goo.gl/maps/m9peM" target="_blank">Map It</a><br>+1 212 243.6103 phone<br>+1 212 675.4441 fax</div>
      	<div style="width:31px; height:143px; float:left"></div>
        <div style="padding-top:10px; width:220px; height:126px; float:left; font-size:14px; line-height:17px"><a href="home.php">Home</a><br>
          <a href="artists.php">Artists</a><br>
          <a href="releases.php">Releases</a><br>
          <a href="compilations.php">Compilations</a><br>
          <a href="publishing.php">Publishing</a><br>
          <a href="about.php">About</a><br>
      	  <a href="contact.php">Contact</a></div>
        <div style="width:26px; height:143px; float:left"></div>
        <div style="width:477px; height:52px; float:right; padding-top:18px"><a href="http://www.twitter.com/NextPlateauEnt" target="_blank"><img src="../images/icon-twitter.png" alt="Twitter" border="0" onMouseOver="this.src='../images/icon-twitterO.png'" onMouseOut="this.src='../images/icon-twitter.png'"></a><a href="http://www.facebook.com/pages/Next-Plateau-Entertainment-Inc/137396359614566" target="_blank"><img src="../images/icon-fb.png" alt="Facebook" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-fbO.png'" onMouseOut="this.src='../images/icon-fb.png'"></a><a href="https://plus.google.com/u/0/b/111442069396927984097/111442069396927984097/posts" target="_blank"><img src="../images/icon-google.png" alt="Google+" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-googleO.png'" onMouseOut="this.src='../images/icon-google.png'"></a><a href="http://www.instagram.com/NextPlateauEntertainment" target="_blank"><img src="../images/icon-instagram.png" alt="Instagram" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-instagramO.png'" onMouseOut="this.src='../images/icon-instagram.png'"></a><a href="http://www.youtube.com/user/NextPlateauEnt?feature=mhee" target="_blank"><img src="../images/icon-youtube.png" alt="YouTube" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-youtubeO.png'" onMouseOut="this.src='../images/icon-youtube.png'"></a><a href="http://www.soundcloud.com/nextplateauinc" target="_blank"><img src="../images/icon-soundcloud.png" alt="Sound Cloud" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-soundcloudO.png'" onMouseOut="this.src='../images/icon-soundcloud.png'"></a><a href="http://www.pinterest.com/nextplateau/" target="_blank"><img src="../images/icon-pinterest.png" alt="Pinterest" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-pinterestO.png'" onMouseOut="this.src='../images/icon-pinterest.png'"></a><a href="http://www.last.fm/user/NextPlateauEnt" target="_blank"><img src="../images/icon-lastfm.png" alt="Last FM" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-lastfmO.png'" onMouseOut="this.src='../images/icon-lastfm.png'"></a><a href="http://www.linkedin.com/company/2758025?trk=tyah" target="_blank"><img src="../images/icon-linkedin.png" alt="LinkedIn" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-linkedinO.png'" onMouseOut="this.src='../images/icon-linkedin.png'"></a><a href="http://www.myspace.com/nextplateauent" target="_blank"><img src="../images/icon-myspace.png" alt="MySpace" border="0" style="padding-left:17px" onMouseOver="this.src='../images/icon-myspaceO.png'" onMouseOut="this.src='../images/icon-myspace.png'"></a></div>
        <?php if($output_form) { ?>
		<form action="#chimp" method="post">
        <div style="width:372px; height:73px; float:left"><input name="Email" type="text" value="<?php echo $email; ?>" onClick="clearField(this, '<?php echo $email; ?>')" onBlur="recallField(this, '<?php echo $email; ?>')" maxlength="47" style="width:370px; height:28px; border:#A7A9AC solid 1px; color:#939598">
        <?php if(!empty($stat)) echo "<br><font size='-1' color=#D71F30>" . $stat . "</font>"; ?>
        </div><div style="width:105px; height:73px; float:right; text-align:right"><input type="image" src="../images/button-submit.png" border="0" alt="Submit" name="mailchimp" onMouseOver="javascript:this.src='../images/button-submitO.png';" onMouseOut="javascript:this.src='../images/button-submit.png';"></div></form>
		<?php } else echo "<font size='-1' color=#D71F30>" . $stat . "</font>"; ?>
  	</div>
</div>
<div style="margin:0 auto; padding-top:23px; width:974px; height:52px; text-align:right" class="footer">&copy;2013 Next Plateau Entertainment. All rights reserved. | Website created by <a href="http://www.subtextinc.com" target="_blank">Subtext, Inc.</a></div>