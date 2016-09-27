$(function() {

	$(".realVote").on({
		click : function ()
		{
			// initialize the user-set rating value  
			rating = 0;
			rating = $(".realVote:checked").val();
			
			questionId = 0;
			questionId = $("[name='hiddenQAId']").val();
			
			userId = 0;
			userId = $("[name='hiddenUserId']").val();
			
			earlierRating = 0;
			if($("[name='hiddenIfMyRatingExists']").val() > 0) {
				earlierRating = $("[name='hiddenIfMyRatingExists']").val();
			}
			
			url = '';
			url = $("[name='url']").val();
			
			$(".realVote:checked").attr("checked", true);
	
			$.post(

					url,

					{ "rating": rating, "questionId": questionId, "userId": userId, "earlierRating": earlierRating },

					function(data) {
			                       
							console.log(data);

					}, 

			"json"
			);

		}
	});

	$("#answerRating").on({
		mouseenter : function ()
		{

		$(".realVote").attr("checked", false);

		}
	});

	
});