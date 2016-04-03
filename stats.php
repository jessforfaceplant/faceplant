<html>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>
	
	
	<?php
		
		$queryMed = "select count(*) from plants where medicinal = 'Y' group by medicinal";
		$queryEd = "select count(*) from plants where edible = 'Y' group by edible";
		$queryPet = "select count(*) from plants where petsafe = 'Y' group by petsafe";
		$queryPop = "with temp as (select plant_id, count(*) as total from favourites group by plant_id) select t.total, p.sci_name, p.com_name, p.cultivar from temp t, plants pwhere t.total = (select max(t.total) from temp t) and t.plant_id = p.plant_id";
		$queryNop = "with temp as (select plant_id, count(*) as total from favourites group by plant_id) select t.total, p.sci_name, p.com_name, p.cultivar from temp t, plants pwhere t.total = (select min(t.total) from temp t) and t.plant_id = p.plant_id";
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
		
		$stid = oci_parse($conn, $queryPop);
		$r = oci_execute($stid);
		while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
			$pop_count = $row['COUNT(*)'];
			echo $row['COUNT(*)'];
		}
		
		$stid = oci_parse($conn, $queryNop);
		$r = oci_execute($stid);
		while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
			$nop_count = $row['COUNT(*)'];
		}
	?>
	
	
	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~STATS~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*STATS*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*STATS*~</p>
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
			<p class="subhead">Most popular</p>
			<?php
				print '<a>' . $pop_count . '</a>';
			?>
			<p class="subhead">Least popular</p>
			<?php
				print '<a>' . $nop_count . '</a>';
			?>

		</div>
		
		
		
	</body>
</html>