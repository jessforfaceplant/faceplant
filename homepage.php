<html>

<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
</head>

<link rel="stylesheet" type="text/css" href="style.css" />

<body class="faceplant">
	<p id="logo">FacePlant</p>
	<div>
		<form>
			Search:<input type="text" name="firstname"><br />
		</form>
		<form id="form" action="attributeQuery.php">
		<div id ="dropdowns">
		General<br />
			<div>
			Colour<br />
				<select name="colour">
					<option value="none" selected></option>
					<option value="blue">Blue</option>
					<option value="red">Red</option>
					<option value="yellow">Yellow</option>
				</select><br />
			</div>
			<div>
			Edible<br />
				<select name="edible">
					<option value="none" selected></option>
					<option value="yes">Yes</option>
					<option value="no">No</option>
				</select><br />
			</div>
			<div>
			Medicinal<br />
				<select name="medicinal">
					<option value="none" selected></option>
					<option value="yes">Yes</option>
					<option value="no">No</option>
				</select><br />
			</div>
			<div>
			Pet Safe<br />
				<select name="petsafe">
					<option value="none" selected></option>
					<option value="yes">Yes</option>
					<option value="no">No</option>
				</select><br />
			</div>
			<div>
			Width<br />
				<select name="width">
					<option value="none" selected></option>
					<option value="0-5">0-5</option>
					<option value="5-10">5-10</option>
					<option value="10+">10+</option>
				</select><br />
			</div>
			<div>
			Height<br />
				<select name="height">
					<option value="none" selected></option>
					<option value="0-5">0-5</option>
					<option value="5-10">5-10</option>
					<option value="10+">10+</option>
				</select><br />
			</div>
		Soil<br />
			<div>
			pH<br />
				<select name="pH">
					<option value="none" selected></option>
					<option value="acidic">Acidic</option>
					<option value="neutral">Neutral</option>
					<option value="alkaline">Alkaline</option>
				</select><br />
			</div>
			<div>
			Humus<br />
				<select name="humus">
					<option value="none" selected></option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
					<option value="high">High</option>
				</select><br />
			</div>
			<div>
			Clay<br />
				<select name="clay">
					<option value="none" selected></option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
					<option value="high">High</option>
				</select><br />
			</div>
			<div>
			Moisture<br />
				<select name="moisture">
					<option value="none" selected></option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
					<option value="high">High</option>
				</select><br />
			</div>
			<div>
			Nitrogen<br />
				<select name="nitrogen">
					<option value="none" selected></option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
					<option value="high">High</option>
				</select><br />
			</div>
			<div>
			Phosphorus<br />
				<select name="phosphorus">
					<option value="none" selected></option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
					<option value="high">High</option>
				</select><br />
			</div>
			<div>
			Potassium<br />
				<select name="potassium">
					<option value="none" selected></option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
					<option value="high">High</option>
				</select><br />
			</div>
			
		Climate<br />
			<div>
			Growth Period (Start)<br />
				<select name="growthperiodstart">
					<option value="none" selected></option>
					<option value="january">January</option>
					<option value="february">February</option>
					<option value="march">March</option>
					<option value="april">April</option>
					<option value="may">May</option>
					<option value="june">June</option>
					<option value="july">July</option>
					<option value="august">August</option>
					<option value="september">September</option>
					<option value="october">October</option>
					<option value="november">November</option>
					<option value="december">December</option>			
				</select><br />
			</div>
			<div>
			Growth Period (End)<br />
				<select name="growthperiodend">
					<option value="none" selected></option>
					<option value="january">January</option>
					<option value="february">February</option>
					<option value="march">March</option>
					<option value="april">April</option>
					<option value="may">May</option>
					<option value="june">June</option>
					<option value="july">July</option>
					<option value="august">August</option>
					<option value="september">September</option>
					<option value="october">October</option>
					<option value="november">November</option>
					<option value="december">December</option>			
				</select><br />
			</div>
			<div>
			Max Temperature<br />
				<input type="text" name="maxtemp"><br />
			</div>
			<div>
			Min Temperature<br />
				<input type="text" name="mintemp"><br />
			</div>
			<div>
			Light<br />
				<select name="light">
					<option value="none" selected></option>
					<option value="low">Low</option>
					<option value="medium">Medium</option>
					<option value="high">High</option>
				</select>
			</div>
			<input type="submit" value="Submit">
		</form>		
	</div>

	<input id="clickMe" type="button" value="Display Names" onclick="loadNames();" />
	<input id="clickMe2" type="button" value="Display All" onclick="loadAll();" />

	<p id='table'></p>
	
	<p id='printOut'></p>
</body>
</html>
