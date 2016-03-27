$(function() {
	$("#subbutt").click(function() {
		var colour_name = $("select#colour_name").val();
		var edible = $("select#edible").val();
		var medicinal = $("select#medicinal").val();
		var petsafe = $("select#petsafe").val();
		var width = $("select#width").val();
		var height = $("select#height").val();
		var humus = $("select#humus").val();
		var clay = $("select#clay").val();
		var moisture = $("select#moisture").val();
		var n = $("select#n").val();
		var p = $("select#p").val();
		var k = $("select#k").val();
		var growthperiod_start = $("select#growthperiod_start").val();
		var growthperiod_end = $("select#growthperiod_end").val();
		var temp_min = $("select#temp_min").val();
		var temp_max = $("select#temp_max").val();
		var light = $("select#light").val();
		
		var dataString = 'colour_name='+ colour_name + '&edible=' + edible + '&medicinal=' + medicinal +
		'&petsafe='+ petsafe + '&width='+ width + '&height='+ height + '&humus='+ humus + 
		'&clay='+ clay + '&moisture='+ moisture + '&n='+ n + '&p='+ p + '&k='+ k + 
		'&growthperiod_start='+ growthperiod_start + '&growthperiod_end='+ 
		growthperiod_end + '&temp_min='+ temp_min + '&temp_max='+ temp_max + '&light='+ light;

		//alert (dataString);return false;
		$.ajax({
			type: "POST",
			url: "attributeQuery.php",
			data: dataString,
			success: function( response ) {
				//alert(response);
				$('#queryTable').html(response);
			}
		});
		return false;
    });
});
