setInterval(function (){
var formData = "nom=";
$.ajax({
  url: "updateMine.php",
  type: 'POST',
  data: {formData: 'produire', otherkey:'other'},
  success: function(data){
   alert(data);
  }
 })
},5000);