<html>
<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	$searchKey = $_REQUEST['plantname'];

	$searchQuery = "";
		
	if (strlen($searchKey) > 0) {
		$searchQuery = ' where ' . 'name = ' . '\'' . $searchKey . '\'';
	}
	
	$query = '<br />select common_name from plant' . $searchQuery . ';';
	
	echo($query);

?>
</html>