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
		
		$queryMed = "select count(*) from plants where medicinal = 'Y' group by medicinal";
		$queryEd = "select count(*) from plants where edible = 'Y' group by edible";
		$queryPet = "select count(*) from plants where petsafe = 'Y' group by petsafe";
		$queryPop = "with temp as (select plant_id, count(*) as total from favourites group by plant_id) select p.plant_id, t.total, p.sci_name, p.com_name, p.cultivar from temp t, plants p where t.total = (select max(t.total) from temp t) and t.plant_id = p.plant_id";
		$queryNop = "with temp as (select plant_id, count(*) as total from favourites group by plant_id) select p.plant_id, t.total, p.sci_name, p.com_name, p.cultivar from temp t, plants p where t.total = (select min(t.total) from temp t) and t.plant_id = p.plant_id";

		// Create connection to Oracle
		$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

		$stid = oci_parse($conn, $queryMed);
		$r = oci_execute($stid);
		while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
			$med_count = $row['COUNT(*)'];
		}
		
		$stid = oci_parse($conn, $queryEd);
		$r = oci_execute($stid);
		while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
			$ed_count = $row['COUNT(*)'];
		}
		
		$stid = oci_parse($conn, $queryPet);
		$r = oci_execute($stid);
		while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
			$pet_count = $row['COUNT(*)'];
		}
		
	?>

	<body>
		<div style="padding-top:20px;">
			<a class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~STATS~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*STATS*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*STATS*~</a>
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
		<div style="padding-bottom: 5px;">

			<p class="subhead">Hey, Faceplant! How many of which plants are what?</p>	
			<table id="infoTable" style="width:50%;">
				<?php 
					print '<tr><td id="rowHeader">Medicinal</td>';
					print '<td>'. $med_count . '</td></tr>';
					print '<tr><td id="rowHeader">Edible</td>';
					print '<td>' . $ed_count . '</td></tr>';
					print '<tr><td id="rowHeader">Petsafe</td>';
					print '<td>' . $pet_count . '</td></tr>';
				?>
			</table>
			<div style="padding-top: 30px;">
				<p class="subhead">Sup Faceplant?! What plants are the most and least popular? Click to find out!</p>	
				<?php
					if($_GET['popular'] == "Most Popular") {
						$stid = oci_parse($conn, $queryPop);
						$r = oci_execute($stid);
						$numresults = 0;
						// Fetch each row in an associative array
						print '<form action="stats.php" method="get">';
						print '<table>';
						print '<td style="background-color: #d9d9d9;">Total</td>';
						print '<td style="background-color: #d9d9d9;">Scientific Name</td>';
						print '<td style="background-color: #d9d9d9;">Common Name</td>';
						print '<td style="background-color: #d9d9d9;">Cultivar</td>';
						while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
							$numresults++;
							$plant_id = $row['PLANT_ID'];
							print '<tr>';
							foreach ($row as $item) {
								if ($item != $plant_id) 
								{
									print '<td>'. '<a href="profile.php?id=' . $plant_id . '">' . ($item !== null ? htmlentities(ucfirst($item), ENT_QUOTES) : '&nbsp'). '</a>' . '</td>';
								}
							
							}
							print '</tr>';
						}
						print '</table>';
						//print '<input type="submit" style="margin-top: 10px;" value="Add to favourites">';
						print '</form>';
	
						if ($numresults == 0) {
							print '<p style="text-align:center; margin-top: 0px;">No plants match your query :(</p>';
						}
						elseif ($numresults == 1) {
							print '<p style="text-align:center; margin-top: 0px;">' . $numresults . ' plant</p>';
						}
						else {
							print '<p style="text-align:center; margin-top: 0px;">' . $numresults . ' plants</p>';
						}
					}
				?>
			</div>
			<div>
			
				<?php
				    if($_GET['popular'] == "Least Popular") {
						$stid = oci_parse($conn, $queryNop);
						$r = oci_execute($stid);
						$numresults = 0;
						// Fetch each row in an associative array
						print '<form action="stats.php" method="get">';
						print '<table>';
						print '<td style="background-color: #d9d9d9;">Total</td>';
						print '<td style="background-color: #d9d9d9;">Scientific Name</td>';
						print '<td style="background-color: #d9d9d9;">Common Name</td>';
						print '<td style="background-color: #d9d9d9;">Cultivar</td>';
						while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
							$numresults++;
							$plant_id = $row['PLANT_ID'];
							print '<tr>';
							foreach ($row as $item) {
								if ($item != $plant_id) 
								{
									print '<td>'. '<a href="profile.php?id=' . $plant_id . '">' . ($item !== null ? htmlentities(ucfirst($item), ENT_QUOTES) : '&nbsp'). '</a>' . '</td>';
								}
							}
							print '</tr>';
						}
						print '</table>';
						print '</form>';
	
						if ($numresults == 0) {
							print '<p style="text-align:center; margin-top: 0px;">No plants match your query :(</p>';
						}
						elseif ($numresults == 1) {
							print '<p style="text-align:center; margin-top: 0px;">' . $numresults . ' plant</p>';
						}
						else {
							print '<p style="text-align:center; margin-top: 0px;">' . $numresults . ' plants</p>';
						}
					}
				?>
				<form action="stats.php">
					<input style="margin-right: 10px;" type="submit" name="popular" style="margin-top: 10px;" value="Most Popular">
					<input type="submit" name="popular" style="margin-top: 10px;" value="Least Popular">
				</form>
			</div>
		</div>
		
		
		
	</body>
</html>