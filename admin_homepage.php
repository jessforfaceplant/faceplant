<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="scripts.js"></script>
	</head>
	
	<?php
		$plantKeys = array('plant_id','com_name','sci_name','cultivar','description','colour_name', 'edible', 'medicinal', 'petsafe', 'width', 'height');
		$soilKeys = array('ph', 'humus', 'clay', 'moisture', 'n', 'p', 'k');
		$climateKeys = array('growthperiod_start', 'growthperiod_end', 'temp_max', 'temp_min', 'light');

		// Plant query
		$plantQuery = "";
		for ($x = 0; $x < sizeof($plantKeys); $x++) {
			if ($_REQUEST[$plantKeys[$x]] == 'none' || $_REQUEST[$plantKeys[$x]] == ''  || $_REQUEST[$plantKeys[$x]] == 'undefined') {
				$success = 0;
				echo("Missing field" . $plantKeys[$x]);
			} 
			$plantQuery = $plantQuery . $_REQUEST[$plantKeys[$x]] . ', ';
		}
		if (strlen($plantQuery) > 0) {
			$plantQuery = substr($plantQuery, 0, strlen($plantQuery) - 2);
		}
		
		// Soil query
		$soilQuery = "";
		for ($x = 0; $x < sizeof($soilKeys); $x++) {
			if ($_REQUEST[$soilKeys[$x]] == 'none' || $_REQUEST[$soilKeys[$x]] == ''  || $_REQUEST[$soilKeys[$x]] == 'undefined') {
				$success = 0;
				echo("Missing field" . $soilKeys[$x]);
			} 
			$soilQuery = $soilQuery . $_REQUEST[$soilKeys[$x]] . ', ';
		}
		if (strlen($soilQuery) > 0) {
			$soilQuery = substr($soilQuery, 0, strlen($soilQuery) - 2);
		}
		
		// Climate query
		$climateQuery = "";
		for ($x = 0; $x < sizeof($climateKeys); $x++) {
			if ($_REQUEST[$climateKeys[$x]] == 'none' || $_REQUEST[$climateKeys[$x]] == ''  || $_REQUEST[$climateKeys[$x]] == 'undefined') {
				$success = 0;
				echo("Missing field" . $climateKeys[$x]);
			} 
			$climateQuery = $climateQuery . $_REQUEST[$climateKeys[$x]] . ', ';
		}
		if (strlen($climateQuery) > 0) {
			$climateQuery = substr($climateQuery, 0, strlen($climateQuery) - 2);
		}
		
		echo($plantQuery);
		echo($soilQuery);
		echo($climateQuery);
		
		Create connection to Oracle
 		$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

		// Does this soil already exist?
		$soilQuery = 'insert into soils values (' . $tupleQuery . ')';
		echo $query;
		$stid = oci_parse($conn, $query);
		$r = oci_execute($stid);
		
		<?php
		// Fetch each row in an associative array;
		while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
			$numresults++;
			$plant_id = $row['PLANT_ID'];
			print '<tr>';
			print '<td style="text-align:center"><input type="checkbox" name="favourite" id="favourite" value="' . $plant_id . '"></td>';
			foreach ($row as $item) {
				if ($item != $plant_id) {
					print '<td>'. '<a href="profile.php?id=' . $plant_id . '">' . ($item !== null ? htmlentities(ucfirst($item), ENT_QUOTES) : '&nbsp'). '</a>' . '</td>';
				}
			}
		}
		

		
		

	?>

	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~ADMIN~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*ADMIN*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*ADMIN*~</p>
		<hr><hr>
		<div class="divrow">
			<form id="tupleForm" action="admin_homepage.php">
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
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Colour</a>
					<select name="colour_name" id="colour_name">
						<option value="none" selected></option>
						<option value="blue">Blue</option>
						<option value="red">Red</option>
						<option value="yellow">Yellow</option>
					</select>
				</div>

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
				
				<p class="subhead">Soil</p>
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">pH</a>
					<select name="ph" id="ph">
						<option value="none" selected></option>
						<option value="L">Acidic</option>
						<option value="M">Neutral</option>
						<option value="H">Alkaline</option>
					</select>
				</div>
				
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Humus</a>
					<select name="humus" id="humus">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Clay</a>
					<select name="clay" id="clay">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Moisture</a>
					<select name="moisture" id="moisture">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Nitrogen</a>
					<select name="n" id="n">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
				
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Phosphorus</a>
					<select name="p" id="p">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Potassium</a>
					<select name="k" id="k">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
		
				<p class="subhead">Climate</p>
				<div style="padding-bottom: 10px;">
					<a>Growth Period</a>
				</div>
				<div style="padding-bottom: 10px;">
					<select name="growthperiod_start" id="growthperiod_start">
						<option value="none" selected></option>
						<option value="January">January</option>
						<option value="February">February</option>
						<option value="March">March</option>
						<option value="April">April</option>
						<option value="May">May</option>
						<option value="June">June</option>
						<option value="July">July</option>
						<option value="August">August</option>
						<option value="September">September</option>
						<option value="October">October</option>
						<option value="November">November</option>
						<option value="December">December</option>			
					</select>
					<a style="padding-left: 10px;padding-right: 10px;">to</a>
					<select name="growthperiod_end" id="growthperiod_end">
						<option value="none" selected></option>
						<option value="January">January</option>
						<option value="February">February</option>
						<option value="March">March</option>
						<option value="April">April</option>
						<option value="May">May</option>
						<option value="June">June</option>
						<option value="July">July</option>
						<option value="August">August</option>
						<option value="September">September</option>
						<option value="October">October</option>
						<option value="November">November</option>
						<option value="December">December</option>			
					</select>
				</div>
				
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Temperature (C)</a>
				</div>
				<div style="padding-bottom: 10px;">
					<input type="text" name="temp_min" id="temp_min" size="5" placeholder="Min">
					<a style="padding-left: 10px;padding-right: 10px;">to</a>
					<input type="text" name="temp_max" id="temp_max" size="5" placeholder="Max">
				</div>
			
				<div style="padding-bottom: 10px;">
				<a style="padding-right: 10px;">Light</a>
					<select name="light" id="light">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
				<div style="padding-top: 10px;">
					<input type="submit" name="submit" id="addplant" value="Add Plant" />
				</div>
			</form>		
		    <form id="deleteForm" action="admin_homepage.php">
				<p class="subhead">Delete Plant</p>
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Plant ID:</a>
					<input type="text" name="plant_id" id="plant_id">
				</div>
				<div style="padding-top: 10px;">
					<input type="submit" name="submit" id="deleteplant" value="Delete Plant" />
				</div>
			</form>
		</div>
		</div>
	</body>
</html>
