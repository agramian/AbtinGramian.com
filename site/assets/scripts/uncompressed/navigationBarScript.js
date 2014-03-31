//NAVIGATION BAR SCRIPT
//var serverName = "localhost";
//var serverName = ".abtingramian.com";
var firstNameAnimDur = 750;
var lastNameAnimDur = 500;
var buttonAnimDur = 250;
var buttonHoverDur = 100;
var currentPage;
var buttonsArray = [ "homeButtonImg", "aboutButtonImg", "workButtonImg", "resumeButtonImg", "contactButtonImg" ];
var homeColor = "#FFF";
var aboutColor = "#fedf0b";
var workColor = "#1f63ae";
var resumeColor = "#9966ff";
var contactColor = "#336600";
var mainContentHeight;
var isMobileDevice;

function runAnimations(pageNum) {    
    //check if mobile device
    if(navigator.platform.indexOf("Win")!=-1){
        currentPlatform="Win";
        isMobileDevice=false;
    } else if(navigator.platform.indexOf("Mac")!=-1){
        currentPlatform="Mac";
        isMobileDevice = false;
    }
    else {
        currentPlatform="Other";
        isMobileDevice = true;
    }

	currentPage = pageNum;

	//set initial mainContent div height
	mainContentHeight = $(window).height() - $("#titleBar").height() - $("#navigationBar").height();
	$("#mainContent").css("height",mainContentHeight + "px");
	if(currentPage==0){
		$("#drawingCanvas").css("height",mainContentHeight + "px");
	}
	
	//set mainContent color
	switch(pageNum) {
		case 0:
			$("#mainContent").css("background-color",homeColor);
			break;
		case 1:
			$("#mainContent").css("background-color",aboutColor);
			$("#abtinPortrait").css("visibility","visible");
			break;
		case 2:
			$("#mainContent").css("background-color",workColor);
			break;
		case 3:
			$("#mainContent").css("background-color",resumeColor);
			break;
		case 4:
			$("#mainContent").css("background-color",contactColor);
			
			break;
	
	}
	//show maincontent since starts out hidden
	$("#mainContent").css("visibility","visible");
	//time mainContent fade in and only draw if on homePage
	if(pageNum==0) {
		$('#mainContent').hide().delay(firstNameAnimDur+lastNameAnimDur+(currentPage*buttonAnimDur)).fadeIn(buttonAnimDur,function() {
            if("ontouchstart" in window){
                document.getElementById('mainContent').addEventListener('touchstart', removeHomeWelcomeMsg);
            }
            else {
                document.getElementById('mainContent').addEventListener('mousemove', removeHomeWelcomeMsg);
            }
		});
	}
	else if(pageNum==1){
		$('#mainContent').hide().delay(firstNameAnimDur+lastNameAnimDur+(currentPage*buttonAnimDur)).fadeIn(buttonAnimDur,function() {
			checkFooter();
			adjustMainContentHeight();
		});
	}
	else if(pageNum==2) {
		$('#mainContent').hide().delay(firstNameAnimDur+lastNameAnimDur+(currentPage*buttonAnimDur)).fadeIn(buttonAnimDur,function() {
			setupGallery();
		});
	}
	else if(pageNum==3) {
		$('#mainContent').hide().delay(firstNameAnimDur+lastNameAnimDur+(currentPage*buttonAnimDur)).fadeIn(buttonAnimDur,function() {		
			var resumePos = $("#resume").offset().top;
			var mainContentPos = $("#mainContent").offset().top;
			var resumeHeight = mainContentHeight-(resumePos-mainContentPos)-60;
			var resumePath;



            $.ajax({
                url: 'resume/getResumePath',
                data: {
                    deviceType: isMobileDevice
                },
                success: function(msg) {
                    resumePath = msg;
                    //resume from google embed if mobile device, else use pdf object
                    if(isMobileDevice) {
                        $('#resume').html("<center><iframe id='resumeEmbed' src='"+resumePath+"' width='880px' height='"+resumeHeight+"px'></iframe></center>");
                    }
                    else { 
                         $('#resume').html("<center><object id='resumeEmbed' width='880px' height='"+resumeHeight+"px' data='"+resumePath+"' #view='FitH' type='application/pdf'> <p>It appears you don't have a PDF plugin for this browser. You can <a href='"+resumePath+"'>click here to download the PDF file.</a></p></object></center>");
                    }
                }
            });
		});
	}
	else if(pageNum==4) {
		$('#mainContent').hide().delay(firstNameAnimDur+lastNameAnimDur+(currentPage*buttonAnimDur)).fadeIn(buttonAnimDur,function() {
			var msgPos = $("#message").offset().top;
			var mainContentPos = $("#mainContent").offset().top;
			var maxMsgHeight = mainContentHeight-(msgPos-mainContentPos)-115;
			$("textarea").css("max-height",maxMsgHeight + "px");
		});
	}
	else {
		$('#mainContent').hide().delay(firstNameAnimDur+lastNameAnimDur+(currentPage*buttonAnimDur)).fadeIn(buttonAnimDur);
	}
	
	//start other animations
	animateFirstName();
}

function animateFirstName() {	
	$("#lastName").css({ "visibility" : "hidden", "top": "95px", "left" : "0px"});
	$("#firstName").css({ "top" : "95px", "left": "-361px"});
	$("#firstName").css({ "visibility" : "visible"});
	$("#firstName").animate({"left" : "0px"}, firstNameAnimDur, animateLastName);
}

function animateLastName() {
	$("#lastName").css({ "visibility" : "visible"});
	$("#lastName").animate({"left" : "361px"}, lastNameAnimDur, animateNavButtons);
}

function animateNavButtons() {
	var i = 0;

	$.each(buttonsArray,function() {
		$("#" + this).delay(i * buttonAnimDur).css({ "visibility" : "visible", "height" : "0px", "width" : "188px", "padding-top" : "60px"}).animate({ "height" : "60px", "padding-top" : "0px" }, buttonAnimDur, addButtonHoverEffect(this,i));
		i++;
	});
	
	$("#firstName").click(function(){reanimateNames();});
	$("#lastName").click(function(){reanimateNames();});
	addNameHoverEffects();
}

function addButtonHoverEffect(buttonImg,num) {
	if(num == currentPage) {
		return;
	}
	$("#" + buttonImg).hover(
		function() {
			$("#" + buttonImg).animate({opacity: 0.5}, buttonHoverDur );
		},
		function() {
			$("#" + buttonImg).animate({opacity: 1.0}, buttonHoverDur );
		}
	);
}

function reanimateNames() {
	//unbind hover
 	$("#firstName").unbind('hover');
	$("#lastName").unbind('hover');
	
	//make sure opacity correct
	$("#firstName").css("opacity", 1.0);
	$("#lastName").css("opacity", 1.0);
	
	//redo animations
	$("#lastName").css({ "visibility" : "hidden", "top": "95px", "left" : "0px"});
	$("#firstName").css({ "top" : "95px", "left": "-361px"});
	$("#firstName").animate({"left" : "0px"}, firstNameAnimDur, function() { $("#lastName").css({ "visibility" : "visible"});
	$("#lastName").animate({"left" : "361px"}, lastNameAnimDur,addNameHoverEffects);});
}

function addNameHoverEffects() {
	$("#firstName").hover(
		function() {
			$("#firstName").animate({opacity: 0.9}, 200 );
			$("#lastName").animate({opacity: 0.9}, 200 );
		},
		function() {
			$("#firstName").animate({opacity: 1.0}, 200 );
			$("#lastName").animate({opacity: 1.0}, 200 );
		}
	);
	
	$("#lastName").hover(
		function() {
			$("#firstName").animate({opacity: 0.9}, 200 );
			$("#lastName").animate({opacity: 0.9}, 200 );
		},
		function() {
			$("#firstName").animate({opacity: 1.0}, 200 );
			$("#lastName").animate({opacity: 1.0}, 200 );
		}
	);
}

function adjustMainContentHeight() {
	//adjust height for resizing window or zooming
	//want no wasted space even if you zoom really far out then back in
	//work page is a special case
	if(currentPage!=2&&currentPage!=3){
		if( (mainContentHeight>$('#mainContent').find('#container').height()) ){
			mainContentHeight = $(window).height() - $("#titleBar").height() - $("#navigationBar").height();
		}
		else {
			mainContentHeight = $(document).height() - $("#titleBar").height() - $("#navigationBar").height();
		}
	}
	if(currentPage==3){
		mainContentHeight = $(window).height() - $("#titleBar").height() - $("#navigationBar").height();
		var resumePos = $("#resume").offset().top;
		var mainContentPos = $("#mainContent").offset().top;
		var resumeHeight = mainContentHeight-(resumePos-mainContentPos)-60;
		if(resumeHeight<300) {
			mainContentHeight += 300-resumeHeight;
			resumeHeight = 300;
		}
		
		$('#resumeEmbed').attr("height",resumeHeight+"px");
	}
	else if(currentPage==2) {
		mainContentHeight = $(window).height() - $("#titleBar").height() - $("#navigationBar").height();
		if( mainContentHeight<mainContentGalleryPageHeight ){
			mainContentHeight = mainContentGalleryPageHeight;
		}
	}
	$("#mainContent").css("height",mainContentHeight + "px");
	
	//page specific adjustments
	if(currentPage==0){
		$("#drawingCanvas").css("height",mainContentHeight + "px");
	}
	else if(currentPage==4) {
		var msgPos = $("#message").offset().top;
		var mainContentPos = $("#mainContent").offset().top;
		var maxMsgHeight = mainContentHeight-(msgPos-mainContentPos)-115;
		$("textarea").css("max-height",maxMsgHeight + "px");
	}
}

function removeHomeWelcomeMsg() {
     if("ontouchstart" in window){
        document.getElementById('mainContent').removeEventListener('touchstart', removeHomeWelcomeMsg);
     }
     else {
        document.getElementById('mainContent').removeEventListener('mousemove', removeHomeWelcomeMsg); 
     }
    
    $("#homeWelcome").remove();
    startDrawing(0);
}

$(window).smartresize(function() {
		adjustMainContentHeight();
});