<?php $page = basename($_SERVER['PHP_SELF']); ?>
<div style="height:145px; border-bottom:#D71F30 5px solid">
	<div style="width:974px; height:145px; margin:0 auto">
    	<div style="height:145px; width:178px; float:left"><img src="images/npe-logo-cp.png" width="178" height="145" border="0" usemap="#Map">
          	<map name="Map">
            <area shape="rect" coords="1,-1,149,124" href="home.php">
          	</map>
		</div>
		<?php if(!empty($_COOKIE['username'])) { ?>
        <div style="height:99px; width:770px; float:right">
        	<div style="float:left; padding-top:5px">
            	<a href="addartist.php"><img src="images/button-add-artist.png" border="0"></a>
                <div style="height:5px"></div>
				<a href="addrelease.php"><img src="images/button-add-release.png" border="0"></a>
                <div style="height:5px"></div>
                <a href="addcompilation.php"><img src="images/button-add-comp.png" border="0"></a>
            </div>
            <?php if($_COOKIE['level'] == "Admin") { ?>
			<div style="float:left; padding-top:5px; margin-left:10px">
            	<a href="users.php"><img src="images/button-users.png" border="0"></a>
                <div style="height:5px"></div>
                <a href="logs.php"><img src="images/button-viewlogs.png" border="0"></a>
            </div>
  			<?php } ?>
        	<div style="float:right; font-size:14px; padding-top:10px">You are logged in as <a href="user.php"><?php echo $_COOKIE['username']; ?></a>. | <a href="logout.php">Log out</a></div>
        </div>
        <div style="height:46px; width:726px; float:right; overflow:hidden"><?php if($page == "home.php") { ?><a href="home.php"><img src="../images/navO_24.png" border="0"></a><?php } else { ?><a href="home.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Home','','../images/navO_24.png',1)"><img src="../images/nav_24.png" alt="Home" name="Home" width="62" height="46" border="0"></a><?php } if(($page == "artists.php") || ($page == "all.php") || ($page == "profile.php")) { ?><a href="artists.php"><img src="../images/navO_25.png" border="0"></a><?php } else { ?><a href="artists.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Artists','','../images/navO_25.png',1)"><img src="../images/nav_25.png" alt="Artists" name="Artists" width="105" height="46" border="0"></a><?php } if(($page == "releases.php") || ($page == "allreleases.php")) { ?><a href="releases.php"><img src="../images/releasesO.png" border="0"></a><?php } else { ?><a href="releases.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Releases','','../images/releasesO.png',1)"><img src="../images/releases.png" alt="Releases" name="Releases" width="105" height="46" border="0"></a><?php } if(($page == "compilations.php") || ($page == "details.php")) { ?><a href="compilations.php"><img src="../images/navO_26.png" border="0"></a><?php } else { ?><a href="compilations.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Compilations','','../images/navO_26.png',1)"><img src="../images/nav_26.png" alt="Compilations" name="Compilations" width="146" height="46" border="0"></a><?php } if($page == "publishing.php") { ?><a href="publishing.php"><img src="../images/navO_27.png" border="0"></a><?php } else { ?><a href="publishing.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Publishing','','../images/navO_27.png',1)"><img src="../images/nav_27.png" alt="Publishing" name="Publishing" width="132" height="46" border="0"></a><?php } if($page == "about.php") { ?><a href="about.php"><img src="../images/navO_28.png" border="0"></a><?php } else { ?><a href="about.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('About','','../images/navO_28.png',1)"><img src="../images/nav_28.png" alt="About" name="About" width="94" height="46" border="0"></a><?php } if($page == "contact.php") { ?><a href="contact.php"><img src="../images/navO_29.png" border="0"></a><?php } else { ?><a href="contact.php" onMouseOut="MM_swapImgRestore()" onMouseOver="MM_swapImage('Contact','','../images/navO_29.png',1)"><img src="../images/nav_29.png" alt="Contact" name="Contact" width="82" height="46" border="0"></a><?php } ?></div><?php } ?>
    </div>
</div>
<div style="height:3px"></div>