<html>
<link rel="stylesheet" type="text/css" href="style.css" />

<?php
	$attributeKeys = array('colour_name', 'edible', 'medicinal', 'petsafe', 'width', 'height', 'ph', 'humus', 'clay', 
	'moisture', 'n', 'p', 'k', 'growthperiod_start', 'growthperiod_end', 'temp_max', 'temp_min', 'light');
	
	$attributeQuery = "";
	
	for ($x = 0; $x < sizeof($attributeKeys); $x++) {
		if ($_REQUEST[$attributeKeys[$x]] != 'none' && $_REQUEST[$attributeKeys[$x]] != ''  && $_REQUEST[$attributeKeys[$x]] != 'undefined') {
			$attributeQuery = $attributeQuery . $attributeKeys[$x] . ' = ' . '\'' . $_REQUEST[$attributeKeys[$x]] . '\'' . ' and ';
		}
	}
	
	if (strlen($attributeQuery) > 0) {
		$attributeQuery = substr($attributeQuery, 0, strlen($attributeQuery) - 5);
		$attributeQuery = ' and ' . $attributeQuery;
	}
	
	// Create connection to Oracle
	$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

	$query = 'select distinct p.plant_id, com_name, sci_name, cultivar from climates cl, soils s, has_colour co, plants p where p.plant_id = co.plant_id and p.climate_id = cl.climate_id and p.soil_id = s.soil_id' . $attributeQuery . ' order by com_name asc';
	//echo($query);
	$stid = oci_parse($conn, $query);
	$r = oci_execute($stid);
	
	$numresults = 0;

	// Fetch each row in an associative array
	print '<table border="1">';
	while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
		$numresults++;
		$plant_id = $row['PLANT_ID'];
		print '<tr>';
		foreach ($row as $item) {
			print '<td>'. '<a href="profile.php?id=' . $plant_id . '">' . ($item !== null ? htmlentities(ucfirst($item), ENT_QUOTES) : '&nbsp'). '</a>' . '</td>';
		}
		print '</tr>';
	}
	print '</table>';
	
	if ($numresults == 0) {
		print '<p style="text-align:center;">The database seems to be empty :(</p>';
	}
	elseif ($numresults == 1) {
		print '<p style="text-align:center;">' . $numresults . ' plant</p>';
	}
	else {
		print '<p style="text-align:center;">' . $numresults . ' plants</p>';
	}
?>
</html>
