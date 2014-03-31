//CONTACT SCRIPTS LOADER
// Load js
LazyLoad.js(['http://code.jquery.com/jquery-latest.min.js', 'scripts/uncompressed/smartresize.js', 'scripts/uncompressed/navigationBarScript.js', 'scripts/uncompressed/contactScript.js'], function () {
	resetContactForm();
	runAnimations(4);
	//delete script tags
	$("script").remove();
});