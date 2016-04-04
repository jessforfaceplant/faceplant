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
		if (sizeof($_GET) == 0) {
			$query_cond = '';
		}
		elseif (!is_null($_GET['plantname'])) {
				$searchKey = $_REQUEST['plantname'];
				$searchKey = strtolower($searchKey);
				//echo($searchKey);
				$searchQuery = "";
				if (strlen($searchKey) > 0) {
					$searchQuery = $searchQuery . ' and lower(com_name) like ' . '\'%' . $searchKey . '%\'';
					$searchQuery = $searchQuery . ' or lower(sci_name) like ' . '\'%' . $searchKey . '%\'';
					$searchQuery = $searchQuery . ' or lower(cultivar) like ' . '\'%' . $searchKey . '%\'';
				}
				$query_cond = $searchQuery;
		}
		else {
			$attributeKeys = array('colour_name', 'edible', 'medicinal', 'petsafe', 'width', 'height', 'ph', 'humus', 'clay', 
			'moisture', 'n', 'p', 'k', 'growthperiod_start', 'growthperiod_end', 'temp_max', 'temp_min', 'light');
	
			$attributeQuery = "";
	
			for ($x = 0; $x < sizeof($attributeKeys); $x++) {
				if ($_REQUEST[$attributeKeys[$x]] != 'none' && $_REQUEST[$attributeKeys[$x]] != ''  && $_REQUEST[$attributeKeys[$x]] != 'undefined') {
					if($attributeKeys[$x] == 'temp_max') {
						$attributeQuery = $attributeQuery . $attributeKeys[$x] . ' >= ' . $_REQUEST[$attributeKeys[$x]] . ' and ';
					}
					else if($attributeKeys[$x] == 'temp_min') {
						$attributeQuery = $attributeQuery . $attributeKeys[$x] . ' <= ' . $_REQUEST[$attributeKeys[$x]] . ' and ';
					}
					else {
						$attributeQuery = $attributeQuery . $attributeKeys[$x] . ' = ' . '\'' . $_REQUEST[$attributeKeys[$x]] . '\'' . ' and ';
					}
				}
			}
	
			if (strlen($attributeQuery) > 0) {
				$attributeQuery = substr($attributeQuery, 0, strlen($attributeQuery) - 5);
				$attributeQuery = ' and ' . $attributeQuery;
			}
			$query_cond = $attributeQuery;
		}
		
		// Create connection to Oracle
		$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

		$query = 'select distinct p.plant_id, com_name, sci_name, cultivar from climates cl, soils s, has_colour co, plants p where p.plant_id = co.plant_id and p.climate_id = cl.climate_id and p.soil_id = s.soil_id' . $query_cond . ' order by com_name asc';
		//echo($query);
		$stid = oci_parse($conn, $query);
		$r = oci_execute($stid);
	?>

	<body>
		<div style="padding-top:20px;">
			<a class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT ;D'" onmouseout="this.innerHTML = 'FACEPLANT :D'" onclick="javascript:location.href='homepage.php'">FACEPLANT :D</a>
			<a style="float:right;"><img id="logoimg" src="logosmall.png" width="80" onmouseover="hover()" onmouseout="unhover()" onclick="javascript:location.href='logopage.html'"></a>
		</div>
		<div class="wrapper" id="nav" style="padding-top:10px;padding-bottom:10px;">
			<a href="stats.php" style="padding-right:15px;">Stats</a>
			<a href="colour_picker.php" style="padding-right:15px;">Colour Picker</a>
			<a href="update.php" style="padding-right:15px;">Update</a>
			<a href="delete.php" style="padding-right:15px;">Delete</a>
		</div>
		<hr><hr>
		<div class="searchColumn">
			<form id="searchForm" action="homepage.php">
				<?php
					$searched_name = $_GET['plantname'];
					print '<input type="text" name="plantname" id="plantname" placeholder="Name or cultivar" value="' . $searched_name . '">';
					print '&nbsp;<input style="margin-top: 10px;" type="submit" name="submit" id="searchbutt" value="Search" />';
				?>
			</form>
			<form id="attributeForm" action="">
				<p class="subhead">General</p>
				<div style="padding-bottom: 5px;">
					<a style="padding-right: 10px;">Colour</a>
					<select name="colour_name" id="colour_name">
						<?php
							$selected_colour = $_GET['colour_name'];
							print '<option value="none" selected></option>';
							print '<option value="red"' . ($selected_colour == "red" ? 'selected' : '') . '>Red</option>';
							print '<option value="orange"' . ($selected_colour == "orange" ? 'selected' : '') . '>Orange</option>';
							print '<option value="yellow"' . ($selected_colour == "yellow" ? 'selected' : '') . '>Yellow</option>';
							print '<option value="green"' . ($selected_colour == "green" ? 'selected' : '') . '>Green</option>';
							print '<option value="blue"' . ($selected_colour == "blue" ? 'selected' : '') . '>Blue</option>';
							print '<option value="indigo"' . ($selected_colour == "indigo" ? 'selected' : '') . '>Indigo</option>';
							print '<option value="violet"' . ($selected_colour == "violet" ? 'selected' : '') . '>Violet</option>';
							print '<option value="white"' . ($selected_colour == "red" ? 'selected' : '') . '>White</option>';
							print '<option value="black"' . ($selected_colour == "black" ? 'selected' : '') . '>Black</option>';
						?>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Edible</a>
					<select name="edible" id="edible">
						<?php
							$selected_edible = $_GET['edible'];
							print '<option value="none" selected></option>';
							print '<option value="Y"' . ($selected_edible == "Y" ? 'selected' : '') . '>Yes</option>';
							print '<option value="N"' . ($selected_edible == "N" ? 'selected' : '') . '>No</option>';
						?>	
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Medicinal</a>
					<select name="medicinal" id="medicinal">
						<?php
							$selected_medicinal = $_GET['medicinal'];
							print '<option value="none" selected></option>';
							print '<option value="Y"' . ($selected_medicinal == "Y" ? 'selected' : '') . '>Yes</option>';
							print '<option value="N"' . ($selected_medicinal == "N" ? 'selected' : '') . '>No</option>';
						?>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Pet Safe</a>
					<select name="petsafe" id="petsafe">
						<?php
							$selected_petsafe = $_GET['petsafe'];
							print '<option value="none" selected></option>';
							print '<option value="Y"' . ($selected_petsafe == "Y" ? 'selected' : '') . '>Yes</option>';
							print '<option value="N"' . ($selected_petsafe == "N" ? 'selected' : '') . '>No</option>';
						?>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Width</a>
					<select name="width" id="width">
						<?php
							$selected_width = $_GET['width'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_width == "L" ? 'selected' : '') . '>Narrow</option>';
							print '<option value="M"' . ($selected_width == "M" ? 'selected' : '') . '>Medium</option>';
							print '<option value="H"' . ($selected_width == "H" ? 'selected' : '') . '>Wide</option>';
						?>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Height</a>
					<select name="height" id="height">
						<?php
							$selected_height = $_GET['height'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_height == "L" ? 'selected' : '') . '>Short</option>';
							print '<option value="M"' . ($selected_height == "M" ? 'selected' : '') . '>Medium</option>';
							print '<option value="H"' . ($selected_height == "H" ? 'selected' : '') . '>Tall</option>';
						?>
					</select>
				</div>
				
				<p class="subhead">Soil</p>
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">pH</a>
					<select name="ph" id="ph">
						<?php
							$selected_ph = $_GET['ph'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_ph == "L" ? 'selected' : '') . '>Acidic</option>';
							print '<option value="M"' . ($selected_ph == "M" ? 'selected' : '') . '>Neutral</option>';
							print '<option value="H"' . ($selected_ph == "H" ? 'selected' : '') . '>Basic</option>';
						?>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Humus</a>
					<select name="humus" id="humus">
						<?php
							$selected_humus = $_GET['humus'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_humus == "L" ? 'selected' : '') . '>Low</option>';
							print '<option value="M"' . ($selected_humus == "M" ? 'selected' : '') . '>Medium</option>';
							print '<option value="H"' . ($selected_humus == "H" ? 'selected' : '') . '>High</option>';
						?>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Clay</a>
					<select name="clay" id="clay">
						<?php
							$selected_clay = $_GET['clay'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_clay == "L" ? 'selected' : '') . '>Low</option>';
							print '<option value="M"' . ($selected_clay == "M" ? 'selected' : '') . '>Medium</option>';
							print '<option value="H"' . ($selected_clay == "H" ? 'selected' : '') . '>High</option>';
						?>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Moisture</a>
					<select name="moisture" id="moisture">
						<?php
							$selected_moisture = $_GET['moisture'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_moisture == "L" ? 'selected' : '') . '>Low</option>';
							print '<option value="M"' . ($selected_moisture == "M" ? 'selected' : '') . '>Medium</option>';
							print '<option value="H"' . ($selected_moisture == "H" ? 'selected' : '') . '>High</option>';
						?>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Nitrogen</a>
					<select name="n" id="n">
						<?php
							$selected_n = $_GET['n'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_n == "L" ? 'selected' : '') . '>Low</option>';
							print '<option value="M"' . ($selected_n == "M" ? 'selected' : '') . '>Medium</option>';
							print '<option value="H"' . ($selected_n == "H" ? 'selected' : '') . '>High</option>';
						?>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Phosphorus</a>
					<select name="p" id="p">
						<?php
							$selected_p = $_GET['p'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_p == "L" ? 'selected' : '') . '>Low</option>';
							print '<option value="M"' . ($selected_p == "M" ? 'selected' : '') . '>Medium</option>';
							print '<option value="H"' . ($selected_p == "H" ? 'selected' : '') . '>High</option>';
						?>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Potassium</a>
					<select name="k" id="k">
						<?php
							$selected_k = $_GET['k'];
							print '<option value="none" selected></option>';
							print '<option value="L"' . ($selected_k == "L" ? 'selected' : '') . '>Low</option>';
							print '<option value="M"' . ($selected_k == "M" ? 'selected' : '') . '>Medium</option>';
							print '<option value="H"' . ($selected_k == "H" ? 'selected' : '') . '>High</option>';
						?>
					</select>
				</div>
		
				<p class="subhead">Climate</p>
				<div style="padding-bottom: 5px;">
					<a>Growth Period</a>
				</div>
				<div style="padding-bottom: 5px;">
					<select name="growthperiod_start" id="growthperiod_start">
						<?php
							$selected_growthperiod_start = $_GET['growthperiod_start'];
							print '<option value="none" selected></option>';
							print '<option value="January"' . ($selected_growthperiod_start == "January" ? 'selected' : '') . '>January</option>';
							print '<option value="February"' . ($selected_growthperiod_start == "February" ? 'selected' : '') . '>February</option>';
							print '<option value="March"' . ($selected_growthperiod_start == "March" ? 'selected' : '') . '>March</option>';
							print '<option value="April"' . ($selected_growthperiod_start == "April" ? 'selected' : '') . '>April</option>';
							print '<option value="May"' . ($selected_growthperiod_start == "May" ? 'selected' : '') . '>May</option>';
							print '<option value="June"' . ($selected_growthperiod_start == "June" ? 'selected' : '') . '>June</option>';
							print '<option value="July"' . ($selected_growthperiod_start == "July" ? 'selected' : '') . '>July</option>';
							print '<option value="August"' . ($selected_growthperiod_start == "August" ? 'selected' : '') . '>August</option>';
							print '<option value="September"' . ($selected_growthperiod_start == "September" ? 'selected' : '') . '>September</option>';
							print '<option value="October"' . ($selected_growthperiod_start == "October" ? 'selected' : '') . '>October</option>';
							print '<option value="November"' . ($selected_growthperiod_start == "Novermber" ? 'selected' : '') . '>November</option>';
							print '<option value="December"' . ($selected_growthperiod_start == "December" ? 'selected' : '') . '>December</option>';	
						?>
					</select>
					<a style="padding-left: 5px;padding-right: 5px;">to</a>
					<select name="growthperiod_end" id="growthperiod_end">
						<?php
							$selected_growthperiod_end = $_GET['growthperiod_end'];
							print '<option value="none" selected></option>';
							print '<option value="January"' . ($selected_growthperiod_end == "January" ? 'selected' : '') . '>January</option>';
							print '<option value="February"' . ($selected_growthperiod_end == "February" ? 'selected' : '') . '>February</option>';
							print '<option value="March"' . ($selected_growthperiod_end == "March" ? 'selected' : '') . '>March</option>';
							print '<option value="April"' . ($selected_growthperiod_end == "April" ? 'selected' : '') . '>April</option>';
							print '<option value="May"' . ($selected_growthperiod_end == "May" ? 'selected' : '') . '>May</option>';
							print '<option value="June"' . ($selected_growthperiod_end == "June" ? 'selected' : '') . '>June</option>';
							print '<option value="July"' . ($selected_growthperiod_end == "July" ? 'selected' : '') . '>July</option>';
							print '<option value="August"' . ($selected_growthperiod_end == "August" ? 'selected' : '') . '>August</option>';
							print '<option value="September"' . ($selected_growthperiod_end == "September" ? 'selected' : '') . '>September</option>';
							print '<option value="October"' . ($selected_growthperiod_end == "October" ? 'selected' : '') . '>October</option>';
							print '<option value="November"' . ($selected_growthperiod_end == "Novermber" ? 'selected' : '') . '>November</option>';
							print '<option value="December"' . ($selected_growthperiod_end == "December" ? 'selected' : '') . '>December</option>';	
						?>		
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Temperature (C)</a>
				</div>
				<div style="padding-bottom: 5px;">
					<?php
						$selected_temp_min = $_GET['temp_min'];
						$selected_temp_max = $_GET['temp_max'];
						print '<input type="text" name="temp_min" id="temp_min" size="5" placeholder="Min" value="' . $selected_temp_min . '">';
						print '<a style="padding-left: 5px;padding-right: 5px;">to</a>';
						print '<input type="text" name="temp_max" id="temp_max" size="5" placeholder="Max" value="' . $selected_temp_max . '">';
					?>
				</div>
				<div style="padding-bottom: 15px;">
					<a style="padding-right: 10px;">Light</a>
						<select name="light" id="light">
							<?php
								$selected_light = $_GET['light'];
								print '<option value="none" selected></option>';
								print '<option value="L"' . ($selected_light == "L" ? 'selected' : '') . '>Low</option>';
								print '<option value="M"' . ($selected_light == "M" ? 'selected' : '') . '>Medium</option>';
								print '<option value="H"' . ($selected_light == "H" ? 'selected' : '') . '>High</option>';
							?>
						</select>
				</div>
				<input type="submit" name="submit" id="attbutt" value="Submit" />
			</form>		
		</div>
		<div class="table" id="queryTable">
		<?php
			$numresults = 0;
			// Fetch each row in an associative array
			if ($r == 1) {
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
					print '<input style="margin-top: 10px;" type="submit" value="Add to favourites">';
				}
				print '</form>';
	
				if ($numresults == 0) {
					print '<p style="text-align:center;">No plants match your query :(</p>';
				}
				else if ($numresults == 1) {
					print '<p style="text-align:center;">' . $numresults . ' plant</p>';
				}
				else {
					print '<p style="text-align:center;">' . $numresults . ' plants</p>';
				}
			} else {
				print '<p style="text-align:center;">There was an error with your query :(</p>';
			}
		?>
		</div>
	</body>
</html>
