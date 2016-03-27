
<html>
<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	// Create connection to Oracle
	$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

	$query = 'select distinct com_name, cultivar from climates cl, soils s, has_colour co, plants p where p.plant_id = co.plant_id and p.climate_id = cl.climate_id and p.soil_id = s.soil_id';
	//echo($query);
	$stid = oci_parse($conn, $query);
	$r = oci_execute($stid);
	
	$has_results = 0;

	// Fetch each row in an associative array
	print '<table border="1">';
	while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
		$has_results = 1;
		print '<tr>';
		foreach ($row as $item) {
			print '<td>'.($item !== null ? htmlentities($item, ENT_QUOTES) : '&nbsp').'</td>';
		}
		print '</tr>';
	}
	print '</table>';
	
	if ($has_results == 0) {
		print '<p style="text-align:center;">The database is empty :(</p>';
	}

?>
</html>
