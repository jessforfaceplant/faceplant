<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="scripts.js"></script>
	</head>
	
	<?php
		if($_GET['submit'] == "Update Plant") {
			$plantKeys = array('com_name','sci_name','cultivar','description', 'edible', 'medicinal', 'petsafe', 'width', 'height');
			$colours = array('red','orange','yellow','green','blue','indigo','violet','white','black');
			
			// Plant query
			$plantQuery = "set ";
			for ($x = 0; $x < sizeof($plantKeys); $x++) {
				if ($_REQUEST[$plantKeys[$x]] != 'none' && $_REQUEST[$plantKeys[$x]] != ''  && $_REQUEST[$plantKeys[$x]] != 'undefined') {
					$plantQuery = $plantQuery . $plantKeys[$x] . ' = \'' . $_REQUEST[$plantKeys[$x]] . '\', ';
				}
			}

			if (strlen($plantQuery) > 4) {
				$plantQuery = substr($plantQuery, 0, strlen($plantQuery) - 2);
			}
		
			$plantQuery = 'update plants ' . $plantQuery . ' where plant_id = \'' . $_REQUEST['plant_id'] . '\'';
		
			//echo($plantQuery);
		
			//Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

			//echo $plantQuery;
			$stid = oci_parse($conn, $plantQuery);
			$success = oci_execute($stid);
		
			//echo("<br> this is success:" . $success);
		}
		if($_GET['submit'] == "Delete Plant") {
			
			$deleteQuery = 'delete from plants where plant_id = ' . $_REQUEST['plant_id'];
		
			echo($deleteQuery);
		
			// //Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

			$stid = oci_parse($conn, $plantQuery);
			$success = oci_execute($stid);
		}
 		

		// Fetch each row in an associative array;
// 		while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
// 			$numresults++;
// 			$plant_id = $row['PLANT_ID'];
// 			print '<tr>';
// 			print '<td style="text-align:center"><input type="checkbox" name="favourite" id="favourite" value="' . $plant_id . '"></td>';
// 			foreach ($row as $item) {
// 				if ($item != $plant_id) {
// 					print '<td>'. '<a href="profile.php?id=' . $plant_id . '">' . ($item !== null ? htmlentities(ucfirst($item), ENT_QUOTES) : '&nbsp'). '</a>' . '</td>';
// 				}
// 			}
// 		}
// 		

		
		

	?>

	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT *~ADMIN~*'" onmouseout="this.innerHTML = 'FACEPLANT ~*ADMIN*~'" onclick="javascript:location.href='homepage.php'">FACEPLANT ~*ADMIN*~</p>
		<hr><hr>
		<div id="names">
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
					<input type="submit" name="submit" id="updatePlant" value="Update Plant" />
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
		<div id="info" style="padding-top:50px;">
			<?php
			if ($_GET['submit'] == "Update Plant") {
				echo($success ? "Update successful" : "Your update failed a constraint");
			}
			if ($_GET['submit'] == "Delete Plant") {
				echo($success ? "Delete successful" : "Your update failed a constraint");
			}
			?>
		</div>
	</body>
</html>
