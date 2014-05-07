<?php
//connect to database
include('php/conn.php');
//query artists
$text = "SELECT a_id, name FROM artists ORDER BY name";
$query = mysqli_query($dbc, $text)
	or die("Error executing query: " . mysqli_error($dbc));
//get number of rows
$total_num_rows = mysqli_num_rows($query);
//put in array
while ($row = mysqli_fetch_array($query)) {
	$a_id[] = $row['a_id'];
	$a_name[] = strtoupper(stripslashes($row['name']));
}
//close database connection
mysqli_close($dbc);
?>
<select name="a1">
	<option value="">-</option>
	<?php for($i=0; $i<$total_num_rows; $i++) { ?>
  	<option value="<?php echo $a_id[$i]; ?>" <?php if($a_id[$i]==$a1) echo " selected"; ?>><?php echo $a_name[$i]; ?></option>
    <?php } ?>
</select>