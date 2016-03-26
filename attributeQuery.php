<html>
<link rel="stylesheet" type="text/css" href="style.css" />

<?php
/*
	$colour = $_REQUEST['colour'];
	$edible = $_REQUEST['edible'];
	$medicinal = $_REQUEST['medicinal'];
	$petsafe = $_REQUEST['petsafe'];
	$width = $_REQUEST['width'];
	$height = $_REQUEST['height'];
	$pH = $_REQUEST['pH'];
	$humus = $_REQUEST['humus'];
	$clay = $_REQUEST['clay'];
	$moisture = $_REQUEST['moisture'];
	$nitrogen = $_REQUEST['nitrogen'];
	$phosphorus = $_REQUEST['phosphorus'];
	$potassium = $_REQUEST['potassium'];
	$growthperiodstart = $_REQUEST['growthperiodstart'];
	$growthperiodend = $_REQUEST['growthperiodend'];
	$maxtemp = $_REQUEST['maxtemp'];
	$mintemp = $_REQUEST['mintemp'];
	$light = $_REQUEST['light'];
*/
	$attributeKeys = array('colour', 'edible', 'medicinal', 'petsafe', 'width', 'height', 'pH', 'humus', 'clay', 
	'moisture', 'nitrogen', 'phosphorus', 'potassium', 'growthperiodstart', 'growthperiodend', 'maxtemp', 'mintemp', 'light');
	
	$attributeQuery = "";
	
	for ($x = 0; $x < sizeof($attributeKeys); $x++) {
		if ($_REQUEST[$attributeKeys[$x]] != 'none' && $_REQUEST[$attributeKeys[$x]] != '') {
			$attributeQuery = $attributeQuery . $attributeKeys[$x] . ' = ' . '\'' . $_REQUEST[$attributeKeys[$x]] . '\'' . ' and ';
		}
	}
	
	if (strlen($attributeQuery) > 0) {
		$attributeQuery = substr($attributeQuery, 0, strlen($attributeQuery) - 5);
		$attributeQuery = ' where ' . $attributeQuery;
	}
	
	echo($attributeQuery);
	
// echo("Colour: " . $colour);
// 	echo("<br />Edible: " . $edible);
// 	echo("<br />Medicinal: " . $medicinal);
// 	echo("<br />Petsafe: " . $petsafe);
// 	echo("<br />Width: " . $width);
// 	echo("<br />Height: " . $height);
// 	echo("<br />pH: " . $pH);
// 	echo("<br />Humus: " . $humus);
// 	echo("<br />Clay: " . $clay);
// 	echo("<br />Moisture: " . $moisture);
// 	echo("<br />Nitrogen: " . $nitrogen);
// 	echo("<br />Phosphorus: " . $phosphorus);
// 	echo("<br />Potassium: " . $potassium);
// 	echo("<br />Growth Period Start: " . $growthperiodstart);
// 	echo("<br />Growth Period End: " . $growthperiodend);
// 	echo("<br />Max Temp: " . $maxtemp);
// 	echo("<br />Min Temp: " . $mintemp);
// 	echo("<br />Light: " . $light);


// // Create connection to Oracle
// $conn = oci_connect("ora_o1c0b", "a55307145", "ug");
// 
$query = '<br />select common_name from climate, soil, colour, plant' . $attributeQuery . ';';
echo($query);
// $stid = oci_parse($conn, $query);
// $r = oci_execute($stid);
// 
// Fetch each row in an associative array
// print '<table border="1">';
// while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
//    print '<tr>';
//    foreach ($row as $item) {
//        print '<td>'.($item !== null ? htmlentities($item, ENT_QUOTES) : 
// '&nbsp').'</td>';
//    }
//    print '</tr>';
// }
// print '</table>';

?>
</html>