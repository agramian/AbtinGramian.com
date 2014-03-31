//CONTACT SCRIPT
var senderContactErrorCode =-1; // 0 means blank, 1 means invalid

var blankEmailMsg = "The email address entered was blank.<br>";
var invalidEmailMsg = "The email address entered was invalid.<br>";

var blankCellMsg = "The cell phone number entered was blank.<br>";
var invalidCellMsg = "The  cell phone number entered was invalid.<br>";

var messageErrorCode =-1; // 0 means blank, 1 means too short
var blankMessageMsg = "The message entered was blank.<br>";
var shortMessageMsg = "The message must be at least 10 characters in length.<br>";

var titleErrorCode =-1; // 0 means blank, 1 means too short
var blankTitleMsg = "The title entered was blank.<br>";
var shortTitleMsg = "The title must be at least 3 characters in length.<br>";

var successMessage = "<p style='color:#0F0'>Your message was successfully sent!</p>";

var errorMessage = "";

$("input[name='messageType']").live('change',function() {
	if($("input[name='messageType']:checked").val()=="email") {
		$("#senderContactCaption").html("Your Email Address:");
		$("#sendMessage").attr("value","Send Email");
	}
	else {
		$("#senderContactCaption").html("Your Cell Phone Number:");
		$("#sendMessage").attr("value","Send Text");
	}
});

$("#sendMessage").live('click', function() {
	senderContactErrorCode = -1;
	messageErrorCode = -1;
	titleErrorCode = -1;
	errorMessage = "";
	
	if ( $.trim( $('#senderContact').val() ) == '' ) {
   		senderContactErrorCode = 0;
	}
	if ( $.trim( $('#messageTitle').val() ) == '' ) {
   		titleErrorCode = 0;
	}
	else if ( $('#messageTitle').val().length<3 ) {
		titleErrorCode = 1;
	}
	if ( $.trim( $('#message').val() ) == '' ) {
   		messageErrorCode = 0;
	}
	else if ( $('#message').val().length<10 ) {
		messageErrorCode = 1;
	}
	
	if(senderContactErrorCode!=-1 || messageErrorCode!=-1 || titleErrorCode!=-1) {
		if(senderContactErrorCode==0) {
			if($("input[name='messageType']:checked").val()=="email")
				errorMessage += blankEmailMsg;
			else
				errorMessage += blankCellMsg;
		}
		if(titleErrorCode == 0) {
			errorMessage += blankTitleMsg;
		}
		if(titleErrorCode == 1) {
			errorMessage += shortTitleMsg;
		}
		if(messageErrorCode == 0) {
			errorMessage += blankMessageMsg;
		}
		if(messageErrorCode == 1) {
			errorMessage += shortMessageMsg;
		}
		
		$("#messageInfo").html(errorMessage+"<br>");
		adjustMainContentHeight();
	}
	else {
		$.ajax({
			url: 'contact/sendMessage',
			data: {
				messageType: $("input[name='messageType']:checked").val(),
				senderContact: $('#senderContact').val(),
				messageTitle: $('#messageTitle').val(),
				message: $('#message').val()
			},
			success: function(msg) {
                while(document.cookie.indexOf("reqURL") != -1) {
                    eraseCookie("reqURL",serverName);
                }
				errorMessage = "";
				if($.trim(msg)=="false"){
					if($("input[name='messageType']:checked").val()=="email")
						errorMessage += invalidEmailMsg;
					else
						errorMessage += invalidCellMsg;
					$("#messageInfo").html(errorMessage+"<br>");
				}
				else if($.trim(msg)=="true"){
					resetContactForm();
					$("#messageInfo").html(successMessage);
					setTimeout(function(){$("#messageInfo").html("");},10000);
				} 
			}
		});	
	}
});

function resetContactForm() {
    $("#senderContactCaption").html("Your Email Address:");
    $("#sendMessage").attr("value","Send Email");
	$('#contactForm').each(function(){
        this.reset();
	});
}