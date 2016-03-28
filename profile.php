<html>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="scripts.js"></script>		
		<?php
			$plant_id = $_GET["id"];

			// Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

			$query = 'select distinct com_name, sci_name, cultivar, description, edible, medicinal, petsafe, height, width, light, growthperiod_start, growthperiod_end, temp_min, temp_max, moisture, n, p, k, humus, clay, ph from climates cl, soils s, has_colour co, plants p where p.plant_id = co.plant_id and p.climate_id = cl.climate_id and p.soil_id = s.soil_id and p.plant_id = \'' . $plant_id . '\'';
			$query_colour = 'select distinct colour_name from climates cl, soils s, has_colour co, plants p where p.plant_id = co.plant_id and p.climate_id = cl.climate_id and p.soil_id = s.soil_id and p.plant_id = \'' . $plant_id . '\'';
			//echo($query);
			//echo('<br>' .  $query_colour);

			$stid = oci_parse($conn, $query);
			$r = oci_execute($stid);

			$stid_colour = oci_parse($conn, $query_colour);
			$r_colour = oci_execute($stid_colour);

			$numresults = 0;

			// Fetch each row in an associative array
			while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
				$com_name = $row['COM_NAME'];
				$sci_name = $row['SCI_NAME'];
				$cultivar = $row['CULTIVAR'];
				$description = $row['DESCRIPTION'];
				$edible = $row['EDIBLE'];
				($edible == 'Y' ? $edible = 'Yes' : $edible = 'No');
				$medicinal = $row['MEDICINAL'];
				($medicinal == 'Y' ? $medicinal = 'Yes' : $medicinal = 'No');
				$petsafe = $row['PETSAFE'];
				($petsafe == 'Y' ? $petsafe = 'Yes' : $petsafe = 'No');
				$height = $row['HEIGHT'];
				switch ($height) {
					case 'L':
						$height = 'Short';
						break;
					case 'M':
						$height = 'Medium';
						break;
					case 'H':
						$height = 'Tall';
						break;
				}
				$width = $row['WIDTH'];
				switch ($width) {
					case 'L':
						$width = 'Narrow';
						break;
					case 'M':
						$width = 'Medium';
						break;
					case 'H':
						$width = 'Wide';
						break;
				}
				$light = $row['LIGHT'];
				switch ($light) {
					case 'L':
						$light = 'Low';
						break;
					case 'M':
						$light = 'Medium';
						break;
					case 'H':
						$light = 'High';
						break;
				}
				$growthperiod_start = $row['GROWTHPERIOD_START'];
				$growthperiod_end = $row['GROWTHPERIOD_END'];
				$temp_min = $row['TEMP_MIN'];
				$temp_max = $row['TEMP_MAX'];
				$moisture = $row['MOISTURE'];
				switch ($moisture) {
					case 'L':
						$moisture = 'Low';
						break;
					case 'M':
						$moisture = 'Medium';
						break;
					case 'H':
						$moisture = 'High';
						break;
				}
				$n = $row['N'];
				switch ($n) {
					case 'L':
						$n = 'Low';
						break;
					case 'M':
						$n = 'Medium';
						break;
					case 'H':
						$n = 'High';
						break;
				}
				$p = $row['P'];
				switch ($p) {
					case 'L':
						$p = 'Low';
						break;
					case 'M':
						$p = 'Medium';
						break;
					case 'H':
						$p = 'High';
						break;
				}
				$k = $row['K'];
				switch ($k) {
					case 'L':
						$k = 'Low';
						break;
					case 'M':
						$k = 'Medium';
						break;
					case 'H':
						$k = 'High';
						break;
				}
				$humus = $row['HUMUS'];
				switch ($humus) {
					case 'L':
						$humus = 'Low';
						break;
					case 'M':
						$humus = 'Medium';
						break;
					case 'H':
						$humus = 'High';
						break;
				}
				$clay = $row['CLAY'];
				switch ($clay) {
					case 'L':
						$clay = 'Low';
						break;
					case 'M':
						$clay = 'Medium';
						break;
					case 'H':
						$clay = 'High';
						break;
				}
				$ph = $row['PH'];
				switch ($ph) {
					case 'L':
						$ph = 'Acidic';
						break;
					case 'M':
						$ph = 'Neutral';
						break;
					case 'H':
						$ph = 'Basic';
						break;
				}
			}
			$colour_array = array();
			while ($row = oci_fetch_array($stid_colour, OCI_RETURN_NULLS+OCI_ASSOC)) {
				foreach ($row as $item) {
					$colour_array[] = $item;
				}
			}
			$colours = implode(', ', $colour_array);
			
			
		?>
	</head>
	
	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT ;D'" onmouseout="this.innerHTML = 'FACEPLANT :D'" onclick="javascript:location.href='homepage.php'">FACEPLANT :D</p>
		<hr><hr>
		<div id="names">
			<?php
				print '<table><tr>';
				foreach ($colour_array as $colour) {
					print '<td id="colour" style="background-color:' . $colour . ';">&nbsp</td>';
				}
				print '</tr></table>';
				print '<h1 id="com_name">' . $com_name . '</h1>';
				print '<h3 id="sci_name">' . $sci_name . '</h3>';
				print '<h3 id="cultivar">' . $cultivar . '</h3>';
				print '<p id="description">' . $description . '</p>';
			?>
			<form id="favourite" action="favourite.php">
				<input type="submit" name="favourite" id="favebutt" value="Favourite" />
			</form>
			<form id="unfavourite" action="unfavourite.php">
				<input type="submit" name="unfavourite" id="badbutt" value="Unfavourite" />
			</form>
		</div>
		<div id="info">
			<table id="infoTable" style="width:100%;">
				<?php 
					print '<tr><td id="rowHeader">Edible</td>';
					print '<td>'. $edible . '</td></tr>';
					print '<tr><td id="rowHeader">Medicinal</td>';
					print '<td>' . $medicinal . '</td></tr>';
					print '<tr><td id="rowHeader">Petsafe</td>';
					print '<td>' . $petsafe . '</td></tr>';
					print '<tr><td id="rowHeader">Height</td>';
					print '<td>' . $height . '</td></tr>';
					print '<tr><td id="rowHeader">Width</td>';
					print '<td>' . $width . '</td></tr>';
					print '<tr><td id="rowHeader">Light</td>';
					print '<td>' . $light . '</td></tr>';
					print '<tr><td id="rowHeader">Growth period</td>';
					print '<td>' . $growthperiod_start . ' to ' . $growthperiod_end . '</td></tr>';
					print '<tr><td id="rowHeader">Growing temperature</td>';
					print '<td>' . $temp_min . ' to ' . $temp_max . '</td></tr>';
					print '<tr><td id="rowHeader">Moisture</td>';
					print '<td>' . $moisture . '</td></tr>';
					print '<tr><td id="rowHeader">Fertilizer (N:P:K)</td>';
					print '<td>' . $n . ' : ' . $p . ' : ' . $k . '</td></tr>';
					print '<tr><td id="rowHeader">Humus</td>';
					print '<td>' . $humus . '</td></tr>';
					print '<tr><td id="rowHeader">Clay</td>';
					print '<td>' . $clay . '</td></tr>';
					print '<tr><td id="rowHeader">pH</td>';
					print '<td>' . $ph . '</td></tr>';
					print '<tr><td id="rowHeader">Colours</td>';
					print '<td>' . $colours . '</td></tr>';
				?>
			</table>
		</div>
	</body>
</html>
