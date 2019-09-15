$(document).ready(function () {

	$('body').on('change','#country',function(){

		var id = $('#country').val();

		$.ajax({
		    url: '/states/' + id,
		    type: 'GET',

		    success: function(success){
		      	
		      	var states = '<option disabled="" selected>Select State</option>';

		      	$.each(success, function (index, val) {
		      		states += "<option value='"+val.id+"'>"+val.name+"</option>";
		      	});

		      	$('#state').html(states);
			}
		})
	});
});
