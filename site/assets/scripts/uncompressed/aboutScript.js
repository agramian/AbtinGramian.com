//ABOUT SCRIPTS
var mainLess = false;

function checkFooter(){
	var aboutFooterHeight = $("#aboutFooter").outerHeight();		
	var aboutTextHeight = $("#aboutText").outerHeight()+50;

	if(!mainLess && mainContentHeight<(aboutTextHeight+aboutFooterHeight)){
		mainLess = true;
		$("#aboutFooter").css("position","relative");
		$("#mainContent").css("height",(aboutTextHeight+aboutFooterHeight+1) + "px");
	}
	else if(mainContentHeight>$('#mainContent').find('#container').height()) {
		$("#aboutFooter").css("position","absolute");
		mainLess=false;
	}
}
function checkFooterMobile(){
	var winOrientation = window.orientation;

	if(winOrientation==0 || winOrientation ==180)
		$("#aboutFooter").css("position","absolute");
	else
		$("#aboutFooter").css("position","relative");
}