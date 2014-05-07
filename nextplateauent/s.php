<?php 
$page = basename($_SERVER['PHP_SELF']); 
$search = "Search by artist, song, compilation or keyword... ";
//check if search was submitted
if(isset( $_POST['search'] ) || isset( $_POST['search_x']) ) {
	$send = true;
	$search_status = '';
	//get search term
	$search = $_POST['Search'];
	//make sure term is not null or default text
	if(empty($search) || $search == "Search by artist, song, compilation or keyword... ") {
		$send = false;
		$search_status = "Please enter a search phrase above";
	}
	if($send) {
		//redirect to search page
		header('Location: search.php?id=' . $search);
		exit;
	}
}
?>