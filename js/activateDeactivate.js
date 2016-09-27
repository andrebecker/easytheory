$(function() {

	// enable submitbutton if tos are accepted
	$("#tosCheck").click(function() {
		
		if($('#tosCheck').is(':checked')) {
		
            $('#submitReg').attr('disabled', false);
			
        } else {
		
            $('#submitReg').attr('disabled', true);
			
        }
		
	});
	
});