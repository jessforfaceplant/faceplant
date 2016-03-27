<html>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
	</head>

	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT ;D'" onmouseout="this.innerHTML = 'FACEPLANT :D'">FACEPLANT :D</p>
		<hr><hr>
		<div class="searchColumn">
			<form id="searchForm" action="searchQuery.php">
				<input type="text" name="plantname" placeholder="Name or cultivar">
				&nbsp;<input type="submit" value="Search">
			</form>
			<form id="attributeForm" action="attributeQuery.php">
				<p class="subhead">General</p>
				<div style="padding-bottom: 5px;">
					<a style="padding-right: 10px;">Colour</a>
					<select name="colour">
						<option value="none" selected></option>
						<option value="blue">Blue</option>
						<option value="red">Red</option>
						<option value="yellow">Yellow</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Edible</a>
					<select name="edible">
						<option value="none" selected></option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Medicinal</a>
					<select name="medicinal">
						<option value="none" selected></option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Pet Safe</a>
					<select name="petsafe">
						<option value="none" selected></option>
						<option value="yes">Yes</option>
						<option value="no">No</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Width</a>
					<select name="width">
						<option value="none" selected></option>
						<option value="0-5">0-5</option>
						<option value="5-10">5-10</option>
						<option value="10+">10+</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Height</a>
					<select name="height">
						<option value="none" selected></option>
						<option value="0-5">0-5</option>
						<option value="5-10">5-10</option>
						<option value="10+">10+</option>
					</select>
				</div>
				
				<p class="subhead">Soil</p>
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">pH</a>
					<select name="pH">
						<option value="none" selected></option>
						<option value="acidic">Acidic</option>
						<option value="neutral">Neutral</option>
						<option value="alkaline">Alkaline</option>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Humus</a>
					<select name="humus">
						<option value="none" selected></option>
						<option value="low">Low</option>
						<option value="medium">Medium</option>
						<option value="high">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Clay</a>
					<select name="clay">
						<option value="none" selected></option>
						<option value="low">Low</option>
						<option value="medium">Medium</option>
						<option value="high">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Moisture</a>
					<select name="moisture">
						<option value="none" selected></option>
						<option value="low">Low</option>
						<option value="medium">Medium</option>
						<option value="high">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Nitrogen</a>
					<select name="nitrogen">
						<option value="none" selected></option>
						<option value="low">Low</option>
						<option value="medium">Medium</option>
						<option value="high">High</option>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Phosphorus</a>
					<select name="phosphorus">
						<option value="none" selected></option>
						<option value="low">Low</option>
						<option value="medium">Medium</option>
						<option value="high">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Potassium</a>
					<select name="potassium">
						<option value="none" selected></option>
						<option value="low">Low</option>
						<option value="medium">Medium</option>
						<option value="high">High</option>
					</select>
				</div>
		
				<p class="subhead">Climate</p>
				<div style="padding-bottom: 5px;">
					<a>Growth Period</a>
				</div>
				<div style="padding-bottom: 5px;">
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
					</select>
					<a style="padding-left: 5px;padding-right: 5px;">to</a>
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
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Temperature (C)</a>
				</div>
				<div style="padding-bottom: 5px;">
					<input type="text" name="mintemp" size="5" placeholder="Min">
					<a style="padding-left: 5px;padding-right: 5px;">to</a>
					<input type="text" name="maxtemp" size="5" placeholder="Max">
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Light</a>
					<select name="light">
						<option value="none" selected></option>
						<option value="low">Low</option>
						<option value="medium">Medium</option>
						<option value="high">High</option>
					</select>
				</div>
				<p><input type="submit" value="Submit"></p>
			</form>		
		</div>
		<div class="table">
			<table>
				<tr>
					<td>Jill</td>
					<td>Smith</td> 
					<td>50</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>Jackson</td> 
					<td>94</td>
				</tr>
				<tr>
					<td>Jill</td>
					<td>Smith</td> 
					<td>50</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>Jackson</td> 
					<td>94</td>
				</tr>
				<tr>
					<td>Jill</td>
					<td>Smith</td> 
					<td>50</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>Jackson</td> 
					<td>94</td>
				</tr>
				<tr>
					<td>Jill</td>
					<td>Smith</td> 
					<td>50</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>Jackson</td> 
					<td>94</td>
				</tr>
				<tr>
					<td>Jill</td>
					<td>Smith</td> 
					<td>50</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>Jackson</td> 
					<td>94</td>
				</tr>
				<tr>
					<td>Jill</td>
					<td>Smith</td> 
					<td>50</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>Jackson</td> 
					<td>94</td>
				</tr>
				<tr>
					<td>Jill</td>
					<td>Smith</td> 
					<td>50</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>Jackson</td> 
					<td>94</td>
				</tr>
				<tr>
					<td>Jill</td>
					<td>Smith</td> 
					<td>50</td>
				</tr>
				<tr>
					<td>Eve</td>
					<td>Jackson</td> 
					<td>94</td>
				</tr>
			</table>
		</div>
	</body>
</html>
