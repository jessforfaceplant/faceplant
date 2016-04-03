<html>
	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="scripts.js"></script>
	</head>
	
	<?php
		if($_GET['deletePlant'] == "Delete Plant") {
			
			$deleteQuery = 'delete from plants where plant_id = ' . $_REQUEST['plant_id'];
		
			echo($deleteQuery);
		
			//Create connection to Oracle
			$conn = oci_connect("ora_o1c0b", "a55307145", "ug");

			$stid = oci_parse($conn, "commit");
			$success = oci_execute($stid, OCI_COMMIT_ON_SUCCESS);
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
					<input type="submit" name="updatePlant" id="updatePlant" value="Update Plant" />
				</div>
			</form>		
		    <form id="deleteForm" action="admin_homepage.php">
				<p class="subhead">Delete Plant</p>
				<div style="padding-bottom: 10px;">
					<a style="padding-right: 10px;">Plant ID:</a>
					<input type="text" name="plant_id" id="plant_id">
				</div>
				<div style="padding-top: 10px;">
					<input type="submit" name="deletePlant" id="deletePlant" value="Delete Plant" />
				</div>
			</form>
		</div>
		<div id="info" style="padding-top:50px;">
			<?php
			if ($_GET['submit'] == "Delete Plant") {
				echo($success ? "Delete successful" : "Your update failed a constraint");
			}
			?>
		</div>
	</body>
</html>
