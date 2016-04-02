<html>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	
	<?php

		$colour = $_GET['colour_name'];
		
		$query = 'select distinct p.plant_id, com_name, sci_name, cultivar from has_colour co, plants p where p.plant_id = co.plant_id ' . $query_cond . ' order by com_name asc';
		
		// Create connection to Oracle
		$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

		$query = 'select distinct p.plant_id, com_name, sci_name, cultivar from climates cl, soils s, has_colour co, plants p where p.plant_id = co.plant_id and p.climate_id = cl.climate_id and p.soil_id = s.soil_id' . $query_cond . ' order by com_name asc';
		//echo($query);
		$stid = oci_parse($conn, $query);
		$r = oci_execute($stid);
	?>
	
	
	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~STATS~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*STATS*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*STATS*~</p>
		<hr>
		<hr>
		
		<div style="padding-bottom: 5px;">
			<a style="padding-right: 10px;">Colour</a>
			<select name="colour_name" id="colour_name">
				<?php
					$selected_colour = $_GET['colour_name'];
					print '<option value="none" selected></option>';
					print '<option value="blue"' . ($selected_colour == "blue" ? 'selected' : '') . '>Blue</option>';
					print '<option value="red"' . ($selected_colour == "red" ? 'selected' : '') . '>Red</option>';
					print '<option value="yellow"' . ($selected_colour == "yellow" ? 'selected' : '') . '>Yellow</option>';
				?>
			</select>
		</div>
		
		
		
	</body>
</html>