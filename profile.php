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
		<div id="info">
			<p id="description">A tall North American plant of the daisy family, with very large golden-rayed flowers.</p>
			<table id="infoTable" style="width:60%">
				<tr>
					<td id="rowHeader">Edible</td>
					<td id="edible">Yes</td> 
				</tr>
				<tr>
					<td id="rowHeader">Medicinal</td>
					<td id="medicinal">Yes</td> 
				</tr>
				<tr>
					<td id="rowHeader">Petsafe</td>
					<td id="petsafe">Yes</td> 
				</tr>
				<tr>
					<td id="rowHeader">Height</td>
					<td id="height">High</td> 
				</tr>
				<tr>
					<td id="rowHeader">Width</td>
					<td id="width">High</td> 
				</tr>
				<tr>
					<td id="rowHeader">Light</td>
					<td id="light">High</td> 
				</tr>
				<tr>
					<td id="rowHeader">Growth period</td>
					<td id="growthperiod">April to September</td> 
				</tr>
				<tr>
					<td id="rowHeader">Growing temperature</td>
					<td id="temperature">4C to 40C</td> 
				</tr>
				<tr>
					<td id="rowHeader">Moisture</td>
					<td id="moisture">Medium</td> 
				</tr>
				<tr>
					<td id="rowHeader">Nitrogen</td>
					<td id="n">Low</td> 
				</tr>
				<tr>
					<td id="rowHeader">Phosphorus</td>
					<td id="n">Medium</td> 
				</tr>
				<tr>
					<td id="rowHeader">Potassium</td>
					<td id="n">Medium</td> 
				</tr>
				<tr>
					<td id="rowHeader">Humus</td>
					<td id="humus">Medium</td> 
				</tr>
				<tr>
					<td id="rowHeader">Clay</td>
					<td id="clay">Medium</td> 
				</tr>
				<tr>
					<td id="rowHeader">pH</td>
					<td id="ph">Medium</td> 
				</tr>
			</table>
		</div>
	</body>
</html>
