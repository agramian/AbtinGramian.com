//GALLERY SCRIPT
var gallery; 
var galleryHeight = 515;
var galleryPagePadding = 20;
var categories = ["All","2D Art","3D Art","Audio","Code","Design","Games","Web"];
optionsObj=new Object();
optionsObj={
	width:720,
	height:515,
	popupLinks: true,
	showInfo: true,
	_toggleInfo: false,
	transition: 'none',
	dataSource: '',
	responsive: true,
	//thumbnails:false,
	//fullscreenCrop:'height',
	//height:'70%',
    //height:0.6959459459459459,
	trueFullscreen: true,
	//imagePan: true,
	//imageCrop: 'height',
	extend: function(options) {
		gallery = Galleria.get(0);
		//for some reason the options don't get set
		//properly without this timeout
		//noticed it after messing with adjusting 
		//mainContent size on work page
		setTimeout("galleryOptions()",1000);
	}
};

var mainContentGalleryPageHeight; 

var mobileGamesWarningMsg = "<br /><br />*Note: The games are only compatible with Windows and Mac PCs. Clicking on the the screenshot above will not start the game on the current device.";

var mobileFlashWarningMsg = "<br /><br />*Note: Flash videos are only compatible with Windows and Mac PCs. Clicking on the the screenshot above will not start the video on the current device.";

var flashDVDWarningMsg = "<br /><div style='font-size:20px;color:#F00'><u>*Pop-ups must be allowed to view the video.&nbsp&nbspYou may have to refresh the page after enabling pop-ups.&nbsp&nbspAfter clicking on the gallery image the film will show up in a separate window.<u></div>";

var javaWarningMsg = "<br /><div style='font-size:20px;color:#F00'><u>*The Java plugin must be installed and enabled on your browser in order to play.<u></div>"; 

var galleriaIconPositionsNormalBottom = "10px";
var galleriaIconPositionsVideoBottom = "40px";
var galleriaIconPositionsCodeBottom = "22px";
var galleryIconXNormal = ["10px","52px","10px"];
var galleryIconXOffsets = ["40px","82px","40px"];

var changingFullscreenMode = false;
var lastGalleryIndex = 0;
var exitingFullscreen = false;
var noTrueFullscreenSupport = false;
var currentCategory;
var currentMediaType;

function setupGallery() {
	//query database
	$.ajax({
		url: 'work/queryDatabase',
		type: 'GET',
		dataType: 'json',
		data: {
			currentDisplay: '0'
		},
		success: function(json) {   
		    
			optionsObj.dataSource = json;
			
			var html = document.documentElement;
			if(!html.requestFullscreen && !html.mozRequestFullScreen &&  !html.webkitRequestFullScreen) {
				noTrueFullscreenSupport = true;
				optionsObj.trueFullscreen = false;
			}
			
			// create the gallery with the options
			$('#gallery').galleria(optionsObj);
			
			// show the gallery
			$('#gallery').show(function() {
				//addExtraButtons();
				$('.galleria-stage').append('<div class="galleria-fullscreen-toggle"><a id="fullscreen"><img src="images/fullscreenButtonSmall.png" title="Fullscreen Toggle"></a></div>');
                $('.galleria-stage').append('<div class="galleria-popout-image"><a id="popout"><img src="images/popoutButtonSmall.png" title="Popout Image"></a></div>');
				$('.galleria-container').append('<div class="grid_18" style="height:50px;"><div class="galleria-categories-container"><div class="grid_1"><br></div>');
				for(var i=0;i<categories.length;i++){
					$('.galleria-categories-container').append('<a class="grid_2 categoryButton" id="' + i + '">' + categories[i] + '</a>');
				}
				$('.galleria-container').append('<div class="grid_1"><br></div></div></div>');
				
				// add custom button functionality
				$(".categoryButton").live('click', function(){updateGallery($(this).attr("id"));});
			});
		}
	});	
}

function galleryOptions() {
	// add keyboard control
	gallery.attachKeyboard({
		left: gallery.prev, // applies the native prev() function
		right: gallery.next,
		up: function() {
			// custom up action
			Galleria.log('up pressed');
		},
		70: function() {
			//f to toggle fullscreen
			gallery.toggleFullscreen();
			//this.play(3000);
		}
	});

	// bind events
	gallery.bind(Galleria.LOADFINISH, function(e) {
		if(exitingFullscreen){
			gallery.show(lastGalleryIndex);
			exitingFullscreen = false;
			setTimeout(function(){$('.galleria-image').css("visibility","visible");},500);
		}
	});
	
	gallery.bind(Galleria.FULLSCREEN_ENTER, function(e){
		gallery.show(gallery.getIndex());

		optionsObj.height = 0;
		optionsObj.width = 0;

		$('.galleria-info').css({"opacity" : "0.0", "top" : "50px"});
		$('.galleria-fullscreen-toggle').css("opacity","0.5");
		$('.galleria-container').css("margin", "auto");
		$('.galleria-categories-container').css("left", ($("#blankLeft").offset().left + $("#blankLeft").outerWidth()));
		gallery.bind(Galleria.RESCALE, function(e) {
			$('.galleria-categories-container').css("left", ($("#blankLeft").offset().left + $("#blankLeft").outerWidth()));
		});
	});
	gallery.bind(Galleria.FULLSCREEN_EXIT, function(e) {
	    if(changingFullscreenMode)
	       return;
		optionsObj.width = 740;
		optionsObj.height = 0.6959459459459459;
		
		$('.galleria-image').unbind("mouseover");
		$('.galleria-image').unbind("mouseout");
		$('.galleria-info').css({"top" : "", "opacity" : ""});
		$('.galleria-fullscreen-toggle').css("opacity","0.5");
		$('.galleria-container').css("margin", "");
		gallery.unbind(Galleria.RESCALE);
		$('.galleria-categories-container').css("left", "");
		
		// update gallery upon to refresh the size and scale
		if(!noTrueFullscreenSupport && !changingFullscreenMode) {
			optionsObj.trueFullscreen = true;
		}
		lastGalleryIndex = gallery.getIndex();
		gallery.setOptions(optionsObj);
		exitingFullscreen = true;
		$('.galleria-image').css("visibility","hidden");
		gallery.load();
	});
	gallery.bind(Galleria.IDLE_ENTER, function(e) {
		$('#fullscreen').hide();
		$('#popout').hide();
	});
	gallery.bind(Galleria.IDLE_EXIT, function(e) {
		$('#fullscreen').show();
		$('#popout').show();
	});
	gallery.bind(Galleria.IMAGE, function(e) {
	    currentCategory=gallery.getData().category;   
	    currentMediaType = gallery.getData().mediaType; 
	    
		//adjust maincontent height to account for varying gallery-info box heights
		if(!gallery.isFullscreen()) {
			mainContentGalleryPageHeight = galleryHeight + $(".galleria-info").outerHeight() + (2*galleryPagePadding);
			adjustMainContentHeight();
		}

		//add info box hover behavior in fullscreen
		if(gallery.isFullscreen()) {
			$('.galleria-image').unbind("mouseover");
			$('.galleria-image').unbind("mouseout");
			$('.galleria-image').mouseover(function() {
				$('.galleria-info').css("opacity", "1.0");
			});
			$('.galleria-image').mouseout(function() {
				$('.galleria-info').css("opacity", "0.0");
			});
		}
		
		//adjust icon positions
		if(currentCategory=="art2D") {			
			adjustIconPositionsBottom(galleriaIconPositionsVideoBottom);
			adjustIconPositionsX(galleryIconXNormal);
		}
		else if(currentCategory=="art3D" || currentCategory=="audio") {
			adjustIconPositionsBottom(galleriaIconPositionsVideoBottom);
			adjustIconPositionsX(galleryIconXNormal);
		}
		else if(currentCategory=="code") {
			adjustIconPositionsBottom(galleriaIconPositionsNormalBottom);
			adjustIconPositionsX(galleryIconXOffsets);
			adjustIconPositionsBottom(galleriaIconPositionsCodeBottom);
		}
		else {
			adjustIconPositionsBottom(galleriaIconPositionsNormalBottom);
			adjustIconPositionsX(galleryIconXNormal);
		}
		//counter opacity
		$('.galleria-counter').css("opacity","0.5");
		
		//reset click binding to allow new assignment
		gallery.$('images').unbind('click');

		if(currentCategory=="games"){
			//disable games on anything other than PC or Mac
			if(isMobileDevice && gallery.getData().backup == 0) {
				$(".galleria-info-description").html($(".galleria-info-description").html() + mobileGamesWarningMsg);
				mainContentGalleryPageHeight = galleryHeight + $(".galleria-info").outerHeight() + (2*galleryPagePadding);
				adjustMainContentHeight();
			}
            else if(isMobileDevice && gallery.getData().backup != 0) {
                adjustIconPositionsBottom(galleriaIconPositionsVideoBottom);
                adjustIconPositionsX(galleryIconXNormal);
                $("#gameDiv").css("visibility","hidden");
                gallery.$('images').bind('click', function() {
                    gallery.$('images').unbind('click');
                    getVideoSrc("#gameDiv",gallery.getData().backup,gallery.getData().loop);
                });
            }            
            else if(!noTrueFullscreenSupport && gallery.isFullscreen() && optionsObj.trueFullscreen) {
                //bind game click to change fullscreen mode
                gallery.$('images').bind('click', function() {
                    if(!noTrueFullscreenSupport && gallery.isFullscreen() && optionsObj.trueFullscreen){
                        changingFullscreenMode = true;
                        gallery.toggleFullscreen();
                        optionsObj.trueFullscreen = false;
                        gallery.setOptions(optionsObj); 
                        $("#navigationBar").css("opacity",0);   
                        $("#mainContent").css("opacity",0);             
                        setTimeout(function(){changingFullscreenMode = false;gallery.toggleFullscreen();$("#mainContent").css("opacity",1);$("#navigationBar").css("opacity",1);},1500);
                    }
                });           
            }
			else {
				if(currentMediaType=="UDK"){
					if(navigator.platform.indexOf("Win")!=-1) {
						$("#gameLink").attr("href", gallery.getData().mediaPath +"-WIN.zip");
					} else if(navigator.platform.indexOf("Mac")!=-1){
						$("#gameLink").attr("href", gallery.getData().mediaPath +"-MAC.zip");
					}
				}
				else if(currentMediaType=="Flash") {
                    gallery.$('images').bind('click', function() {
                        if(gallery.isFullscreen()) {
                            $('.galleria-info').css("opacity", "0.0");
                            $('.galleria-image').unbind("mouseover");
                            $('.galleria-image').unbind("mouseout");
                        }  
                        getFlashSrc("#gameDiv",gallery.getData().mediaPath);
                    });
                }
                else {
                    if(gallery.getData().title=="PONGRE") {
                        $(".galleria-info-description").html($(".galleria-info-description").html() + javaWarningMsg);
                        mainContentGalleryPageHeight = galleryHeight + $(".galleria-info").outerHeight() + (2*galleryPagePadding);
                        adjustMainContentHeight();
                    }
                    gallery.$('images').bind('click', function() {
                        gallery.$('images').unbind('click');
                        if(gallery.isFullscreen()) {
                            $('.galleria-info').css("opacity", "0.0");
                            $('.galleria-image').unbind("mouseover");
                            $('.galleria-image').unbind("mouseout");
                        }
                        if(currentMediaType=="IFrame") {   
                            $("#gameDiv").html(gallery.getData().iframeCode);
                            $("#gameDiv").css("visibility","visible");
                            gallery.getActiveImage().style.display = "none"; 
                        }
                        else if(currentMediaType=="Panda3D") {
                            var hasPlugin = false;
                            if ( $.browser.msie ) {
                                $("#gameDiv").html(gallery.getData().iframeCode);
                                $("#gameDiv").css("visibility","visible");
                                gallery.getActiveImage().style.display = "none"; 
                            }
                            else {
                                if(detectPanda3D())
                                    hasPlugin = true;                            
                                else 
                                    $("#gameDiv").css("position","relative");
                                getGameSrc("#gameDiv",gallery.getData().mediaPath,hasPlugin,"both",0,0);
                            }                                
                        }
                        else if(currentMediaType=="Ogre") {
                            if(currentPlatform=="Win"){
                                getGameSrc("#gameDiv",gallery.getData().mediaPath,hasPlugin,"Win",$("#gameDiv").width(),$("#gameDiv").height());
                                //if(gallery.isFullscreen()){
                                  //  $(window).smartresize(function(){getGameSrc("#gameDiv",gallery.getData().mediaPath,true,"Win",$("#gameDiv").width(),$("#gameDiv").height());});                                   
                                //} 
                            }
                            else if(currentPlatform=="Mac"&&!(gallery.isFullscreen() && optionsObj.trueFullscreen==true)&&!changingFullscreenMode){
                                getGameSrc("#gameDiv",gallery.getData().mediaPath,hasPlugin,"Mac",$("#gameDiv").width(),$("#gameDiv").height());
                                //getGameSrc("#gameDiv",gallery.getData().mediaPath,hasPlugin,"Mac",screen.width,screen.height);
                                //setTimeout(function() {pongrePlayer.setSize($("#gameDiv").width(),$("#gameDiv").height());},1000);
                                //if(gallery.isFullscreen())
                                  //  $(window).smartresize(function(){ogreResize});
                            }
                        }                      
                    });
                }				
			}
		}
		else if(currentCategory=="art2D"){			
			$("#art2DDiv").css("visibility","hidden");
			if(currentMediaType=="Flash"&&!isMobileDevice) {
				gallery.$('images').bind('click', function() {
					gallery.$('images').unbind('click');
					getFlashSrc("#art2DDiv",gallery.getData().mediaPath);
				});
			}
            else if(gallery.getData().backup != 0) {
                adjustIconPositionsBottom(galleriaIconPositionsVideoBottom);
                adjustIconPositionsX(galleryIconXNormal);
                $("#art2DDiv").css("visibility","hidden");
                gallery.$('images').bind('click', function() {
                    gallery.$('images').unbind('click');
                    getVideoSrc("#art2DDiv",gallery.getData().backup,gallery.getData().loop);
                });
            }
		}
        else if(currentCategory=="art3D"){          
            $("#art3DDiv").css("visibility","hidden");
            if(currentMediaType=="Video") {
                gallery.$('images').bind('click', function() {
                    gallery.$('images').unbind('click');
                    getVideoSrc("#art3DDiv",gallery.getData().mediaPath,gallery.getData().loop);
                });
            }
        }
        else if(currentCategory=="audio"){          
            $("#audioDiv").css("visibility","hidden");
            if(currentMediaType=="Video") {
                gallery.$('images').bind('click', function() {
                    gallery.$('images').unbind('click');
                    getVideoSrc("#audioDiv",gallery.getData().mediaPath,gallery.getData().loop);
                });
            }
            else if(currentMediaType=="Audio") {
                gallery.$('images').bind('click', function() {
                    gallery.$('images').unbind('click');
                    getAudioSrc("#audioDiv",gallery.getData().mediaPath);
                });
            }
            else if(currentMediaType=="FlashDVD") {
                if(!isMobileDevice) {   
                    $(".galleria-info-description").html($(".galleria-info-description").html() + flashDVDWarningMsg);
                    mainContentGalleryPageHeight = galleryHeight + $(".galleria-info").outerHeight() + (2*galleryPagePadding);
                    adjustMainContentHeight();
                    gallery.$('images').bind('click', function() {
                        getFlashDVDSrc();
                    });                    
                } 
                else if(gallery.getData().backup != 0) {
                    adjustIconPositionsBottom(galleriaIconPositionsVideoBottom);
                    adjustIconPositionsX(galleryIconXNormal);
                    $("#audioDiv").css("visibility","hidden");
                    gallery.$('images').bind('click', function() {
                        gallery.$('images').unbind('click');
                        getVideoSrc("#audioDiv",gallery.getData().backup,gallery.getData().loop);
                    });
                }
            }                       
        }
		else if(currentCategory=="code"){			
			getCodeSrc();
		}
	});

	// counter functions
	$('.galleria-counter').mouseover(function() {
		$('.galleria-counter').css("opacity","1.0");
	});
	$('.galleria-counter').mouseout(function() {
		$('.galleria-counter').css("opacity","0.5");
	});

	// add fullscreen mouse functions
	$('#fullscreen').click(function() {
       // to keep code hidden until width adjusted
       if(currentCategory=="code")
           $("#codeSrcDiv").css("opacity",0);
		gallery.toggleFullscreen();		  
	});
	$('#fullscreen').mouseover(function() {
		$('.galleria-fullscreen-toggle').css("opacity","1.0");
	});
	$('#fullscreen').mouseout(function() {
		$('.galleria-fullscreen-toggle').css("opacity","0.5");
	});
	// add popout mouse functions
	$('#popout').click(function() {
		gallery.openLightbox();
	});
	$('#popout').mouseover(function() {
		$('.galleria-popout-image').css("opacity","1.0");
	});
	$('#popout').mouseout(function() {
		$('.galleria-popout-image').css("opacity","0.5");
	});
}

function updateGallery(id){
	$('.galleria-info').css("opacity", "0.0");
	$.ajax({
		url: 'work/queryDatabase',
		type: 'GET',
		dataType: 'json',
		data: {
			currentDisplay: id
		},
		success: function(json) {
			optionsObj.dataSource = json;
			gallery.setOptions(optionsObj);
			gallery.load();
			if(gallery.isFullscreen()&&noTrueFullscreenSupport){
				setTimeout(function(){$('.galleria-container').css({"width" : "100%", "height" : "100%"});},1000);
			}
			$('.galleria-info').css("opacity", "1.0");
		}
	});	
}

function getVideoSrc(mediaDiv,mediaPath,loop){
    $.ajax({
        url: 'work/getVideoSrc',
        type: 'GET',
        dataType: 'html',
        data: {
            src: mediaPath
        },
        success: function(src) {
            $(mediaDiv).html(src);
            createVideoPlayer(loop,mediaDiv);
            setTimeout(function(){$(mediaDiv).css("visibility","visible");gallery.getActiveImage().style.display = "none";},500);
        }
    }); 
}

function getAudioSrc(mediaDiv,mediaPath){
    $.ajax({
        url: 'work/getAudioSrc',
        type: 'GET',
        dataType: 'html',
        data: {
            src: mediaPath,
            mediaType: currentMediaType
        },
        success: function(src) {
            $(mediaDiv).html(src);
            createAudioPlayer(); 
            setTimeout(function(){$(mediaDiv).css("visibility","visible");gallery.getActiveImage().style.display = "none";},500);
        }
    }); 
}

function getFlashSrc(mediaDiv,mediaPath){
    $.ajax({
        url: 'work/getFlashSrc',
        type: 'GET',
        dataType: 'html',
        data: {
            src: mediaPath
        },
        success: function(src) {
            $(mediaDiv).html(src);
            setTimeout(function(){$(mediaDiv).css("visibility","visible");gallery.getActiveImage().style.display = "none";},500);
        }
    }); 
}

function getGameSrc(mediaDiv,mediaPath,hasPlug,plat,w,h){
    $.ajax({
        url: 'work/getGameSrc',
        type: 'GET',
        dataType: 'html',
        data: {
            src: mediaPath,
            mediaType: currentMediaType,
            hasPlugin: hasPlug,
            platform: plat,
            width: w,
            height: h
        },
        success: function(src) {
            $("#gameDiv").html(src);       
            setTimeout(function(){$("#gameDiv").css("visibility","visible");gallery.getActiveImage().style.display = "none";},1000);
            
        }
    }); 
}
    
function getCodeSrc(){
    $.ajax({
        url: 'work/getCodeSrc',
        type: 'GET',
        dataType: 'html',
        data: {
            src: gallery.getData().mediaPath
        },
        success: function(src) {
            $("#codeDiv").html(src);
            prettyPrint();
            $("#codeSrcDiv").css("width",document.getElementById('codeDiv').scrollWidth);
            gallery.getActiveImage().style.display = "none";
            setTimeout(function(){$("#codeSrcDiv").css("opacity",1);},500);
        }
    });
}

function getFlashDVDSrc(){
    $.ajax({
        url: gallery.getData().mediaPath+".html",
        type: 'GET',
        dataType: 'html',
        success: function(src) {
            //alert(src);
            var newwin = window.open("", "", "width=1280,height=720,directories=no,toolbar=no,location=no,status=no,menubar=no,scrollbars=no,resizable=no");
            newwin.innerWidth = 1280;
            newwin.innerHeight = 720;
            xpos = screen.width/2 - newwin.outerWidth/2;
            ypos = screen.height/2 - newwin.outerHeight/2;
            newwin.moveTo(xpos,ypos);
            
            var temp = "<html>"
            temp += "<head><title>"+gallery.getData().title+"</title></head>"
            temp += "<style type='text/css'>"
            temp += "#Background_horizon{text-align: center;position: absolute;top: 50%;left: 0px;width: 100%;height: 1px;overflow: visible;display: block;z-index: 1;visibility: visible;}"
            temp += "#Background_div {width: 1280px;height: 720px;margin-left: -640px;position: absolute;top: -360px;left: 50%;visibility: visible;}"    
            temp += "</style>"
            temp += "<body bgcolor='#000000'>"
            temp += "<div id='Background_horizon'><div id='Background_div'>"
            temp += gallery.getData().iframeCode;
            temp += "</div></div>"
            temp += "</body>"
            temp += "</html>"            
            
            newwin.document.write(temp);  
        }
    });
}

function adjustIconPositionsBottom(bottom) {
	$('.galleria-counter').css("bottom",bottom);
	$('.galleria-popout-image').css("bottom",bottom);
	$('.galleria-fullscreen-toggle').css("bottom",bottom);
}

function adjustIconPositionsX(xOffset) {
	$('.galleria-counter').css("left", xOffset[0]);
	$('.galleria-popout-image').css("right",xOffset[1]);
	$('.galleria-fullscreen-toggle').css("right",xOffset[2]);
}