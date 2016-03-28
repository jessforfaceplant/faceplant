<html>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="scripts.js"></script>
	</head>

	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT ;D'" onmouseout="this.innerHTML = 'FACEPLANT :D'" onclick="javascript:location.href='homepage.php'">FACEPLANT :D</p>
		<hr><hr>
		<div id="names">
			<h1 id="com_name">Sunflower</h1>
			<h3 id="sci_name">Helianthus annus</h3>
			<h3 id="cultivar">Italian White</h3>
		</div>
		<div id="options">
			<form id="favourite" action="favourite.php">
				<input type="submit" name="favourite" id="favebutt" value="Favourite" />
			</form>
			<form id="unfavourite" action="unfavourite.php">
				<input type="submit" name="unfavourite" id="badbutt" value="Unfavourite" />
			</form>
		</div>
		<p id="description">A tall North American plant of the daisy family, with very large golden-rayed flowers.</p>
		<table style="width:100%">
			<tr>
				<td>Edible</td>
				<td id="edible">Yes</td> 
			</tr>
			<tr>
				<td>Medicinal</td>
				<td id="medicinal">Yes</td> 
			</tr>
			<tr>
				<td>Petsafe</td>
				<td id="petsafe">Yes</td> 
			</tr>
			<tr>
				<td>Height</td>
				<td id="height">High</td> 
			</tr>
			<tr>
				<td>Width</td>
				<td id="width">High</td> 
			</tr>
			<tr>
				<td>Light</td>
				<td id="light">High</td> 
			</tr>
			<tr>
				<td>Growth period start</td>
				<td id="growthperiod">April</td> 
			</tr>
			<tr>
				<td>Growth period end</td>
				<td id="growthperiod">September</td> 
			</tr>
			<tr>
				<td>Minimum growing temperature</td>
				<td id="temperature">4C</td> 
			</tr>
			<tr>
				<td>Maximum growing temperature</td>
				<td id="temperature">40C</td> 
			</tr>
			<tr>
				<td>Moisture</td>
				<td id="moisture">Medium</td> 
			</tr>
			<tr>
				<td>Nitrogen</td>
				<td id="n">Low</td> 
			</tr>
			<tr>
				<td>Phosphorus</td>
				<td id="n">Medium</td> 
			</tr>
			<tr>
				<td>Potassium</td>
				<td id="n">Medium</td> 
			</tr>
			<tr>
				<td>Humus</td>
				<td id="humus">Medium</td> 
			</tr>
			<tr>
				<td>Clay</td>
				<td id="clay">Medium</td> 
			</tr>
			<tr>
				<td>pH</td>
				<td id="ph">Medium</td> 
			</tr>
		</table>
		
		<div class="searchColumn">
			
		</div>
		<div>
		</div>
	</body>
</html>
