<html>

	<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
		<link href='https://fonts.googleapis.com/css?family=Arvo' rel='stylesheet' type='text/css'>
		<link rel="stylesheet" type="text/css" href="style.css" />
		<script src="scripts.js"></script>
	</head>

	<body>
		<p class="wrapper" id="logo" onmouseover="this.innerHTML = 'FACEPLANT ;D'" onmouseout="this.innerHTML = 'FACEPLANT :D'">FACEPLANT :D</p>
		<hr><hr>
		<div class="searchColumn">
			<form id="searchForm" action="searchQuery.php">
				<input type="text" name="plantname" placeholder="Name or cultivar">
				&nbsp;<input type="submit" value="Search">
			</form>
			<form id="attributeForm" action="">
				<p class="subhead">General</p>
				<div style="padding-bottom: 5px;">
					<a style="padding-right: 10px;">Colour</a>
					<select name="colour_name" id="colour_name">
						<option value="none" selected></option>
						<option value="blue">Blue</option>
						<option value="red">Red</option>
						<option value="yellow">Yellow</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Edible</a>
					<select name="edible" id="edible">
						<option value="none" selected></option>
						<option value="Y">Yes</option>
						<option value="N">No</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Medicinal</a>
					<select name="medicinal" id="medicinal">
						<option value="none" selected></option>
						<option value="Y">Yes</option>
						<option value="N">No</option>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Pet Safe</a>
					<select name="petsafe" id="petsafe">
						<option value="none" selected></option>
						<option value="Y">Yes</option>
						<option value="N">No</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Width</a>
					<select name="width" id="width">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Height</a>
					<select name="height" id="height">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
				
				<p class="subhead">Soil</p>
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">pH</a>
					<select name="ph" id="ph">
						<option value="none" selected></option>
						<option value="L">Acidic</option>
						<option value="M">Neutral</option>
						<option value="H">Alkaline</option>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Humus</a>
					<select name="humus" id="humus">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Clay</a>
					<select name="clay" id="clay">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Moisture</a>
					<select name="moisture" id="moisture">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Nitrogen</a>
					<select name="n" id="n">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Phosphorus</a>
					<select name="p" id="p">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Potassium</a>
					<select name="k" id="k">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
		
				<p class="subhead">Climate</p>
				<div style="padding-bottom: 5px;">
					<a>Growth Period</a>
				</div>
				<div style="padding-bottom: 5px;">
					<select name="growthperiod_start" id="growthperiod_start">
						<option value="none" selected></option>
						<option value="January">January</option>
						<option value="February">February</option>
						<option value="March">March</option>
						<option value="April">April</option>
						<option value="May">May</option>
						<option value="June">June</option>
						<option value="July">July</option>
						<option value="August">August</option>
						<option value="September">September</option>
						<option value="October">October</option>
						<option value="November">November</option>
						<option value="December">December</option>			
					</select>
					<a style="padding-left: 5px;padding-right: 5px;">to</a>
					<select name="growthperiod_end" id="growthperiod_end">
						<option value="none" selected></option>
						<option value="January">January</option>
						<option value="February">February</option>
						<option value="March">March</option>
						<option value="April">April</option>
						<option value="May">May</option>
						<option value="June">June</option>
						<option value="July">July</option>
						<option value="August">August</option>
						<option value="September">September</option>
						<option value="October">October</option>
						<option value="November">November</option>
						<option value="December">December</option>			
					</select>
				</div>
				
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Temperature (C)</a>
				</div>
				<div style="padding-bottom: 5px;">
					<input type="text" name="temp_min" id="temp_min" size="5" placeholder="Min">
					<a style="padding-left: 5px;padding-right: 5px;">to</a>
					<input type="text" name="temp_max" id="temp_max" size="5" placeholder="Max">
				</div>
			
				<div style="padding-bottom: 5px;">
				<a style="padding-right: 10px;">Light</a>
					<select name="light" id="light">
						<option value="none" selected></option>
						<option value="L">Low</option>
						<option value="M">Medium</option>
						<option value="H">High</option>
					</select>
				</div>
				<p><input type="submit" name="submit" id="subbutt" value="Submit" /></p>
			</form>		
		</div>
		<div class="table" id="queryTable">
		</div>
	</body>
</html>
