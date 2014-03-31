//HOME SCRIPTS LOADER
// Load js
LazyLoad.js(['http://code.jquery.com/jquery-latest.min.js', 'scripts/homeScripts.min.js'], function () {
	runAnimations(0);
	//delete script tags
	$("script").remove();
});

