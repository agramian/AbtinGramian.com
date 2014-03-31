//CONTACT SCRIPTS LOADER
// Load js
LazyLoad.js(['http://code.jquery.com/jquery-latest.min.js', 'scripts/contactScripts.min.js'], function () {
	resetContactForm();
	runAnimations(4);
	//delete script tags
	$("script").remove();
});