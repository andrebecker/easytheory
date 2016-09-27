$(function() {

	// insert comment in db
	$("#submitMyComment").on({
		click : function ()
		{
			// initialize the content of the comment  
			commentText = '';
			commentText = $("#addCommentInputField").val();
			
			questionId = 0;
			questionId = $("[name='hiddenQAId']").val();
						
			userId = 0;
			userId = $("[name='hiddenUserId']").val();
			
			url = '';
			url = $("[name='url']").val();
	
			$.post(

					url,

					{ "commentText": commentText, "questionId": questionId, "userId": userId },

					function(data) {
			                       
						$("#displayAllComments").click();
						$("#addCommentInputField").val('');
						$(".outerCommentContainer").animate({ scrollTop: $('.outerCommentContainer').height()+10000 }, 500);

					}, 

			"json"
			);

		}
	});
	
	$("#displayAllComments").on({
		click : function ()
		{
	
			url = '';
			url = $("[name='url']").val();
			
			questionId = 0;
			questionId = $("[name='hiddenQAId']").val();
		
			$.post(

				url,

				{ "questionId": questionId },

				function(data) {
									   
					for(i=0; i<data.length; i++) {
					
						if(i%2 == 0) {
						var newstring = '<div class="fakeHgroupBright">';
						newstring += data[i];
						newstring += '</div>';
							$('.commentContainer').append(newstring);
						} else {
							var newstring = '<div class="fakeHgroupDark">';
						newstring += data[i];
						newstring += '</div>';
							$('.commentContainer').append(newstring);
						}
						
					}

				}, 

				"json"
			);
		
		}
	});
	
});