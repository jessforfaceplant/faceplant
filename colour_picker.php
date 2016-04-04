<html>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script>
			function hover() {
				var image = document.getElementById('logoimg');
				image.src = "logosmallhover.png";
			}
		
			function unhover() {
				var image = document.getElementById('logoimg');
				image.src = "logosmall.png";
			}
		</script>
	</head>
	
	
	<?php
		
		if(strlen($_SERVER['QUERY_STRING']) >= 0) {
			$colour_querry_arr = array();
			$selectedColours = array();
		
			$arg_array = explode("&", $_SERVER['QUERY_STRING']);
			foreach ($arg_array as $arg) {
				$pair = explode("=", $arg);
				if ($pair[0] == 'colour_name') {
					$colour_querry_arr[] = "insert into temp_colours values ('" . $pair[1] . "')";
					$selectedColours[] = $pair[1];
				}
			}

			// Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");
		
			
			$stid = oci_parse($conn, 'truncate table temp_colours');
			if (oci_commit($conn)) {
				$r = oci_execute($stid, OCI_NO_AUTO_COMMIT);
			}
			$c = oci_commit ($conn);			
		
			foreach ($colour_querry_arr as $colour_querry) {
				$stid = oci_parse($conn, $colour_querry);
				$r = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
			}
			
			$query = 'with temp as (select distinct H.plant_id from has_colour H where not exists ((select T.colour_name from temp_colours T) MINUS (select I.colour_name from has_colour I where I.plant_id = H.plant_id))) select p.plant_id, p.com_name, p.sci_name, p.cultivar from temp t, plants p where p.plant_id = t.plant_id';
		}
		else {
			$query = 'select distinct p.plant_id, com_name, sci_name, cultivar from climates cl, soils s, has_colour co, plants p where p.plant_id = co.plant_id and p.climate_id = cl.climate_id and p.soil_id = s.soil_id order by com_name asc';
		}
		//echo($query);
		$stid = oci_parse($conn, $query);
		$r = oci_execute($stid);
	?>
	
	
	<body>
		<div style="padding-top:20px;">
			<a class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~COLOUR~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*COLOUR*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*COLOUR*~</a>
			<a style="float:right;"><img id="logoimg" src="logosmall.png" width="80" onmouseover="hover()" onmouseout="unhover()" onclick="javascript:location.href='logopage.html'"></a>
		</div>
		<div class="wrapper" id="nav" style="padding-top:10px;padding-bottom:10px;">
			<a href="stats.php" style="padding-right:15px;">Stats</a>
			<a href="colour_picker.php" style="padding-right:15px;">Colour Picker</a>
			<a href="update.php" style="padding-right:15px;">Update</a>
			<a href="delete.php" style="padding-right:15px;">Delete</a>
		</div>
		<hr>
		<hr>
		
		<div class="searchColumn">
			<p class="subhead" style="padding-right: 30px;">What colours do you look for in a plant?</p>			
			<form action="colour_picker.php">
				<?php
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="red"' . (in_array("red", $selectedColours) ? "checked" : "") . '>Red</a><br>';
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="orange"' . (in_array("orange", $selectedColours) ? "checked" : "") . '>Orange</a><br>';
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="yellow"' . (in_array("yellow", $selectedColours) ? "checked" : "") . '>Yellow</a><br>';
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="green"' . (in_array("green", $selectedColours) ? "checked" : "") . '>Green</a><br>';
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="blue"' . (in_array("blue", $selectedColours) ? "checked" : "") . '>Blue</a><br>';
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="indigo"' . (in_array("indigo", $selectedColours) ? "checked" : "") . '>Indigo</a><br>';
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="violet"' . (in_array("violet", $selectedColours) ? "checked" : "") . '>Violet</a><br>';
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="white"' . (in_array("white", $selectedColours) ? "checked" : "") . '>White</a><br>';
					print '<a><input style="margin-right:10px;" type="checkbox" name="colour_name" value="black"' . (in_array("black", $selectedColours) ? "checked" : "") . '>Black</a><br>';
				?>
				<input style="margin-top: 10px;" type="submit" name="submit" id="colour" value="Search" />
			</form>
		</div>
		<div class="table" id="queryTable" style="padding-top: 43px;">
		<?php
			$numresults = 0;
			// Fetch each row in an associative array
			print '<form action="favourite.php" method="get">';
			print '<table>';
			print '<tr><td style="background-color: #d9d9d9;"></td>';
			print '<td style="background-color: #d9d9d9;">Common Name</td>';
			print '<td style="background-color: #d9d9d9;">Scientific Name</td>';
			print '<td style="background-color: #d9d9d9;">Cultivar</td></tr>';
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
				print '</tr>';
			}
			print '</table>';
			if ($numresults != 0) {
				print '<input type="submit" style="margin-top: 10px;" value="Add to favourites">';
			}
			print '</form>';
	
			if ($numresults == 0) {
				print '<p style="text-align:center;">No plants match your query :(</p>';
			}
			elseif ($numresults == 1) {
				print '<p style="text-align:center;">' . $numresults . ' plant</p>';
			}
			else {
				print '<p style="text-align:center;">' . $numresults . ' plants</p>';
			}
		?>
		</div>
	</body>
</html>
