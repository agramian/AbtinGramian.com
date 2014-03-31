//ABOUT SCRIPTS LOADER
// Load js
LazyLoad.js(['http://code.jquery.com/jquery-latest.min.js', 'scripts/aboutScripts.min.js'], function () {
	runAnimations(1);

	if(isMobileDevice) {
		// need to adjust based on start orientation
		checkFooter();
		adjustMainContentHeight();
		
		$(window).bind( 'orientationchange', function(e){
			checkFooterMobile();
			adjustMainContentHeight();
		});
	}
	else {
		$(window).smartresize(function() {
			checkFooter();
			adjustMainContentHeight();
		});
	}

	//delete script tags
	$("script").remove();
});