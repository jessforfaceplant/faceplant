<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="scripts.js"></script>
	</head>
	
	<?php
		if($_GET['deletePlant'] == "Delete Plant") {
			
			$deletePlantQuery = 'delete from plants where plant_id = ' . $_GET['plant_id'];
		
			//echo($deletePlantQuery);
		
			// Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

			// Delete
			$c = oci_commit($conn);
			$stidDeletePlant = oci_parse($conn, $deletePlantQuery);
			$successDeletePlant = oci_execute($stidDeletePlant, OCI_COMMIT_ON_SUCCESS);
			
			// Show all plants
			$queryAllPlants = 'select distinct plant_id, com_name, sci_name, cultivar from plants p order by plant_id asc';
			$stidAllPlants = oci_parse($conn, $queryAllPlants);
			$successAllPlants = oci_execute($stidAllPlants, OCI_COMMIT_ON_SUCCESS);
		
			oci_close($conn);
		}
		if($_GET['deleteSoil'] == "Delete Soil") {
			
			$deleteSoilQuery = 'delete from soils where soil_id = ' . $_GET['soil_id'];
		
			//echo($deleteSoilQuery);
		
			// Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

			// Delete
			$c = oci_commit($conn);
			$stidDeleteSoil = oci_parse($conn, $deleteSoilQuery);
			$successDeleteSoil = oci_execute($stidDeleteSoil, OCI_COMMIT_ON_SUCCESS);
			
			// Show all plants
			$queryAllSoils = 'select distinct soil_id, moisture, n, p, k, humus, clay, ph from soils s order by soil_id asc';
			$stidAllSoils = oci_parse($conn, $queryAllSoils);
			$successAllSoils = oci_execute($stidAllSoils, OCI_COMMIT_ON_SUCCESS);
		
			oci_close($conn);
		}
	?>

	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~DELETE~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*DELETE*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*DELETE*~</p>
		<div class="wrapper" id="nav" style="padding-top:10px;padding-bottom:10px;">
			<a href="stats.php" style="padding-right:15px;">Stats</a>
			<a href="colour_picker.php" style="padding-right:15px;">Colour Picker</a>
			<a href="update.php" style="padding-right:15px;">Update</a>
			<a href="delete.php" style="padding-right:15px;">Delete</a>
		</div>		
		<hr><hr>
		<div id="names" class="searchColumn" style="width:30%;float:left;clear:left;">
		    <form id="deleteForm" action="delete.php">
				<p class="subhead">Plant</p>
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Plant ID:</a>
					<input type="text" name="plant_id" id="plant_id">
				</div>
				<div style="padding-top: 10px;">
					<input type="submit" name="deletePlant" id="deletePlant" value="Delete Plant" />
				</div>
			</form>
			<form id="deleteSoil" action="delete.php">
				<p class="subhead">Soil</p>
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Soil ID:</a>
					<input type="text" name="soil_id" id="soil_id">
				</div>
				<div style="padding-top: 10px;">
					<input type="submit" name="deleteSoil" id="deleteSoil" value="Delete Soil" />
				</div>
			</form>
			<?php
				if (($_GET['deletePlant'] == "Delete Plant" && $successDeletePlant != 1) || ($_GET['deleteSoil'] == "Delete Soil" && $successDeleteSoil != 1)) {
					print '<p style="color:red;">There was an error with your delete :(</p>';
				}
			?>
		</div>
		<div class="table" id="queryTable" style="width:70%;float:right;clear:right;">
			<?php
				if ($_GET['deletePlant'] == "Delete Plant" && $successDeletePlant == 1) {
					$numresults = 0;
					// Fetch each row in an associative array
					print '<p style="text-align:center;">Remaining plants</p>';
					print '<form action="delete.php" method="get">';
					print '<table>';
					print '<tr><td style="background-color: #d9d9d9;">ID</td>';
					print '<td style="background-color: #d9d9d9;">Common Name</td>';
					print '<td style="background-color: #d9d9d9;">Scientific Name</td>';
					print '<td style="background-color: #d9d9d9;">Cultivar</td></tr>';
					while ($row = oci_fetch_array($stidAllPlants, OCI_RETURN_NULLS+OCI_ASSOC)) {
						$numresults++;
						$plant_id = $row['PLANT_ID'];
						print '<tr>';
						foreach ($row as $item) {
							print '<td>'. '<a href="profile.php?id=' . $plant_id . '">' . ($item !== null ? htmlentities(ucfirst($item), ENT_QUOTES) : '&nbsp'). '</a>' . '</td>';
						}
						print '</tr>';
					}
					print '</table>';
					print '</form>';

					if ($numresults == 0) {
						print '<p style="text-align:center;">No plants remain :(</p>';
					}
					else if ($numresults == 1) {
						print '<p style="text-align:center;">' . $numresults . ' plant</p>';
					}
					else {
						print '<p style="text-align:center;">' . $numresults . ' plants</p>';
					}
				}
				if ($_GET['deleteSoil'] == "Delete Soil" && $successDeleteSoil == 1) {
					$numresults = 0;
					// Fetch each row in an associative array
					print '<p style="text-align:center;">Remaining soils</p>';
					print '<form action="delete.php" method="get">';
					print '<table>';
					print '<tr><td style="background-color: #d9d9d9;">ID</td>';
					print '<td style="background-color: #d9d9d9;">Moisture</td>';
					print '<td style="background-color: #d9d9d9;">N</td>';
					print '<td style="background-color: #d9d9d9;">P</td>';
					print '<td style="background-color: #d9d9d9;">K</td>';
					print '<td style="background-color: #d9d9d9;">Humus</td>';
					print '<td style="background-color: #d9d9d9;">Clay</td>';
					print '<td style="background-color: #d9d9d9;">pH</td></tr>';
					while ($row = oci_fetch_array($stidAllSoils, OCI_RETURN_NULLS+OCI_ASSOC)) {
						$numresults++;
						$plant_id = $row['PLANT_ID'];
						print '<tr>';
						foreach ($row as $item) {
							print '<td>'. '<a href="profile.php?id=' . $plant_id . '">' . ($item !== null ? htmlentities(ucfirst($item), ENT_QUOTES) : '&nbsp'). '</a>' . '</td>';
						}
						print '</tr>';
					}
					print '</table>';
					print '</form>';

					if ($numresults == 0) {
						print '<p style="text-align:center;">No soils remain :(</p>';
					}
					else if ($numresults == 1) {
						print '<p style="text-align:center;">' . $numresults . ' soil</p>';
					}
					else {
						print '<p style="text-align:center;">' . $numresults . ' soils</p>';
					}
				}
			?>
		</div>
	</body>
</html>
