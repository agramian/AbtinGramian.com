// home page drawing
//Light Blue - #1F63AE
//Dark Blue - #000099
//Brown - #663300
//Green - #336600
//Light Grey - #CCCCCC
//Red - #BB2224
//Purple - #9966FF
//Yellow - #FEDF0B


var colorArray = ["#000000","#1F63AE","#663300","#000099","#336600","#CCCCCC","#BB2224","#9966FF","#FEDF0B"];
var colorPickedRecently = new Array(9);
var currentColor;
var i;
var colorsPicked;
var lineWidth = 1.0;
var lastMouseX;
var lastMouseY;
var lineOffsetY = 0;
var lineSettings = {color: '#000000', stroke: 1};

function startDrawing(pageNum){	
	resetColorPickedRecently();
	// account for starting with black by default
	colorsPicked=1;
	colorPickedRecently[0] = true;
	
	lineOffsetY = $("#mainContent").offset().top;
	
	//check if touch device
	if("ontouchstart" in window){
 		//make fixed width for mobile touch devices
 		$("#drawingCanvas").css({"width":"960px","overflow":"hidden"});
 		
 		document.getElementById('mainContent').addEventListener('touchstart', function(e) {
 			lastMouseX = e.touches[0].pageX;
			lastMouseY = e.touches[0].pageY;
		}, false);
		
		document.getElementById('mainContent').addEventListener('touchend', function(e) {
 			changeLineColor();
		}, false);
		
		document.getElementById('mainContent').addEventListener('touchmove', function(e) {
 			e.preventDefault();
 			draw(e.touches[0]);
		}, false);
	}
	else {	
		$("#mainContent").mouseover(function(e){
			lastMouseX = e.pageX;
			lastMouseY = e.pageY;
		});
		
		$("#mainContent").mouseout(function(e){
			lastMouseX = e.pageX;
			lastMouseY = e.pageY;
		});
	
		$("#mainContent").mousemove(function(e){
			draw(e);
		});
		
		$("#mainContent").click(function(e){
			changeLineColor();
		});
	}
}

function resetColorPickedRecently(){
	for(i=0;i<9;i++)
		colorPickedRecently[i] = false;
	colorsPicked = 0;
}

function changeLineColor(){
	if(colorsPicked>=9){
		resetColorPickedRecently();
	}
	
	// pick a random color from the array
	do{
		i = Math.floor(Math.random()*(9));
	}while(colorPickedRecently[i])
	colorPickedRecently[i] = true;
	currentColor = i;
	colorsPicked++;
}

function draw(mouse){
		
	if(lineWidth<20 && (Math.pow((mouse.pageX-lastMouseX),2) + Math.pow((mouse.pageY-lastMouseY),2))<40)
		lineWidth+=0.25;
	else if(lineWidth>1.0)
		lineWidth-=0.25;
	
	lineSettings = {color: colorArray[currentColor], stroke: lineWidth};
	
	$("#drawingCanvas").drawLine(lastMouseX,lastMouseY-lineOffsetY,mouse.pageX,mouse.pageY-lineOffsetY,lineSettings) ;
	
	lastMouseX = mouse.pageX;
	lastMouseY = mouse.pageY;
	
}