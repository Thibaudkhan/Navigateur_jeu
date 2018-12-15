setInterval(function (){
	var formData = "nom=";
	$.ajax({
			url: "update.php",
			type: 'POST',
			data: {formData: 'produire'},
				success: function(data){
					document.getElementById('ressources').innerHTML =data;
				}
		})
	},2000);
