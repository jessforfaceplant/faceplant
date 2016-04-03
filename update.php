<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="scripts.js"></script>
	</head>
	
	<?php	
		if($_GET['updatePlant'] == "Update Plant") {
			$plantKeys = array('com_name','sci_name','cultivar','description', 'edible', 'medicinal', 'petsafe', 'width', 'height');
			
			// Plant query
			$updateQuery = "set ";
			for ($x = 0; $x < sizeof($plantKeys); $x++) {
				if ($_REQUEST[$plantKeys[$x]] != 'none' && $_REQUEST[$plantKeys[$x]] != ''  && $_REQUEST[$plantKeys[$x]] != 'undefined') {
					$updateQuery = $updateQuery . $plantKeys[$x] . ' = \'' . $_REQUEST[$plantKeys[$x]] . '\', ';
				}
			}
			if (strlen($updateQuery) > 4) {
				$updateQuery = substr($updateQuery, 0, strlen($updateQuery) - 2);
			}
		
			$updateQuery = 'update plants ' . $updateQuery . ' where plant_id = \'' . $_REQUEST['plant_id'] . '\'';
					
			//Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");
			$stid = oci_parse($conn, $updateQuery);
			$success = oci_execute($stid);
			
			$plant_id = $_REQUEST['plant_id'];
			$query = 'select distinct com_name, sci_name, cultivar, description, edible, medicinal, petsafe, height, width, light, growthperiod_start, growthperiod_end, temp_min, temp_max, moisture, n, p, k, humus, clay, ph from climates cl, soils s, has_colour co, plants p where p.plant_id = co.plant_id and p.climate_id = cl.climate_id and p.soil_id = s.soil_id and p.plant_id = \'' . $plant_id . '\'';
		
			$stid_refresh = oci_parse($conn, $query);
			$r = oci_execute($stid_refresh);
			
			// Fetch each row in an associative array
			while ($row = oci_fetch_array($stid_refresh, OCI_RETURN_NULLS+OCI_ASSOC)) {
				$com_name = ucfirst($row['COM_NAME']);
				$sci_name = ucfirst($row['SCI_NAME']);
				$cultivar = ucfirst($row['CULTIVAR']);
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
			}
		
		}
	?>
		
	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~UPDATE~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*UPDATE*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*UPDATE*~</p>
		<div class="wrapper" id="nav" style="padding-top:10px;padding-bottom:10px;">
			<a href="stats.php" style="padding-right:15px;">Stats</a>
			<a href="colour_picker.php" style="padding-right:15px;">Colour Picker</a>
			<a href="update.php" style="padding-right:15px;">Update</a>
			<a href="delete.php" style="padding-right:15px;">Delete</a>
		</div>
		<hr><hr>
		<div id="names">
			<form id="tupleForm" action="update.php">
				<p class="subhead">Names/Description</p>
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Plant ID:</a>
					<input type="text" name="plant_id" id="plant_id">
				</div>
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Common Name:</a>
					<input type="text" name="com_name" id="com_name">
				</div>
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Scientific Name:</a>
					<input type="text" name="sci_name" id="sci_name">
				</div>
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Cultivar:</a>
					<input type="text" name="cultivar" id="cultivar">
				</div>
				<div>Description:
					<p><textarea rows="4" cols="50" name="description" placeholder="Enter description here..." id="description" form="tupleForm"></textarea></p>
				</div>
											
				<p class="subhead">General</p>
				<!-- 
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Colour:</a>
					<input type="text" name="colour" id="colour">
				</div>
 				-->

				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Edible</a>
					<select name="edible" id="edible">
						<option value="none" selected></option>
						<option value="Y">Yes</option>
						<option value="N">No</option>
					</select>
				</div>
			
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Medicinal</a>
					<select name="medicinal" id="medicinal">
						<option value="none" selected></option>
						<option value="Y">Yes</option>
						<option value="N">No</option>
					</select>
				</div>
				
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Pet Safe</a>
					<select name="petsafe" id="petsafe">
						<option value="none" selected></option>
						<option value="Y">Yes</option>
						<option value="N">No</option>
					</select>
				</div>
			
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Width</a>
					<select name="width" id="width">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Height</a>
					<select name="height" id="height">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
				<div style="padding-top: 10px;">
					<input type="submit" name="updatePlant" id="updatePlant" value="Update Plant" />
				</div>
			</form>	
		</div>
		<div id="info">
			<table id="infoTable" style="margin-top: 30px; width:100%;">
				<?php 
					print '<tr><td id="rowHeader">Plant ID</td>';
					print '<td>'. $plant_id . '</td></tr>';
					print '<tr><td id="rowHeader">Scientific Name</td>';
					print '<td>'. $sci_name . '</td></tr>';
					print '<tr><td id="rowHeader">Common Name</td>';
					print '<td>'. $com_name . '</td></tr>';
					print '<tr><td id="rowHeader">Cultivar</td>';
					print '<td>' . $cultivar . '</td></tr>';
					print '<tr><td id="rowHeader">Description</td>';
					print '<td>' . $description . '</td></tr>';
					print '<tr><td id="rowHeader">Edible</td>';
					print '<td>'. $edible . '</td></tr>';
					print '<tr><td id="rowHeader">Medicinal</td>';
					print '<td>'. $medicinal . '</td></tr>';
					print '<tr><td id="rowHeader">Petsafe</td>';
					print '<td>' . $petsafe . '</td></tr>';
					print '<tr><td id="rowHeader">Height</td>';
					print '<td>' . $height . '</td></tr>';
					print '<tr><td id="rowHeader">Width</td>';
					print '<td>' . $width . '</td></tr>';
				?>
			</table>
		</div>
		<div id="info" style="padding-top:50px;">
			<?php
			if ($_GET['updatePlant'] == "Update Plant") {
				echo($success ? "Update successful" : "Your update failed a constraint");
			}
			?>
		</div>
	</body>
</html>
