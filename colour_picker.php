<html>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	
	<?php
		
		if(strlen($_SERVER['QUERY_STRING']) > 0) {
			$colour_querry_arr = array();
		
			$arg_array = explode("&", $_SERVER['QUERY_STRING']);
			foreach ($arg_array as $arg) {
				$pair = explode("=", $arg);
				if ($pair[0] == 'colour_name') {
					$colour_querry_arr[] = "insert into temp_colours values ('" . $pair[1] . "')";
				}
			}

			// Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");
		
			//$stid = oci_parse($conn, 'delete from temp_colours');
			//$r = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
		
			foreach ($colour_querry_arr as $colour_querry) {
				$stid = oci_parse($conn, $colour_querry);
				$r = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
			}

			$query = 'select distinct H.plant_id from has_colour H where not exists ((select T.colour_name from temp_colours T) MINUS (select I.colour_name  from has_colour I where I.plant_id = H.plant_id))';
			//echo($query);
			$stid = oci_parse($conn, $query);
			$r = oci_execute($stid);
		}
	?>
	
	
	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~COLOUR~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*COLOUR*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*COLOUR*~</p>
		<hr>
		<hr>
		
		<div style="padding-bottom: 5px;">
			<p class="subhead">Colour</p>
			<p>What colours do you look for in a plant?</p>			
			<form action="colour_picker.php">
				<a><input type="checkbox" name="colour_name" value="red">Red</a><br>
				<a><input type="checkbox" name="colour_name" value="orange">Orange</a><br>
				<a><input type="checkbox" name="colour_name" value="yellow">Yellow</a><br>
				<a><input type="checkbox" name="colour_name" value="green">Green</a><br>
				<a><input type="checkbox" name="colour_name" value="blue">Blue</a><br>
				<a><input type="checkbox" name="colour_name" value="indigo">Indigo</a><br>
				<a><input type="checkbox" name="colour_name" value="violet">Violet</a><br>
				<a><input type="checkbox" name="colour_name" value="white">White</a><br>
				<a><input type="checkbox" name="colour_name" value="black">Black</a><br>
				<input type="submit" name="submit" id="colour" value="Search" />
			</form>
		</div>
		
		
		
	</body>
</html>
