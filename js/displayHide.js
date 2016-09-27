$(function() {

	// if clicked show answer, display it as well as the show comments option
	$("#showAnswer").click(function() {
	
		$("#answer").show();
		$("#commentLink").show();
		
	});
	
	// if clicked show comments, display them
	$("#displayAllComments").click(function(event) {
	
		event.preventDefault();
		$(".outerCommentContainer").show();
		$(".commentDisplay").show();

	});
	
	// if clicked add comment, display the textfield
	$("#addComments").click(function(event) {
	
		event.preventDefault();
		$(".outerCommentContainer").show();
		$(".addComentTextField").show();
		$(".commentDisplay").show();
		$(".commentDisplay").scrollTop($('.outerCommentContainer').position().top);

	});
	
	// if clicked show imprint, display it
	$("#showImprint").click(function(event) {
	
		event.preventDefault();
		
		if($("#imprint").is(":visible")) {
			$("#imprint").hide();
		} else {
			$("#imprint").show();
		}
		
	});
	
	// equals height of section and aside
	$("#content").height($("#aside").height());
	
	var height = $(window).height() * 0.77;
	$('section').css('height', height);
	$('aside').css('height', height);
	
});