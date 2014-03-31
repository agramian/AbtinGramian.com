//WORK SCRIPTS LOADER
// Load js
LazyLoad.js(['http://code.jquery.com/jquery-latest.min.js', 'scripts/uncompressed/smartresize.js', 'scripts/uncompressed/navigationBarScript.js', 'scripts/galleria/galleria-1.2.8.min.js', 'scripts/galleria/themes/classic/galleria.classic.min.js', 'scripts/uncompressed/galleryScript.js'], function () {
	$("#gallery").hide();
	runAnimations(2);
	//load secondary css
    LazyLoad.css("styles/AGStylesWork.min.css");
	//load secondary js
	LazyLoad.js(['scripts/mediaelement/build/mediaelement-and-player.min.js',"scripts/uncompressed/mediaPlayerScript.js", "scripts/google-code-prettify/prettify.js", "scripts/uncompressed/ogreResize.js","scripts/uncompressed/DetectPanda3D.js"],function() {
        //delete script tags
        $("script").remove();	    
	});
});