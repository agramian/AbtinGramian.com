//HOME SCRIPTS LOADER
// Load js
LazyLoad.js(['http://code.jquery.com/jquery-latest.min.js', 'scripts/uncompressed/smartresize.js', 'scripts/uncompressed/navigationBarScript.js', 'scripts/drawing/drawing.js', 'scripts/drawing/jquery.drawinglibrary.js'], function () {
	runAnimations(0);
	//delete script tags
	$("script").remove();
});

