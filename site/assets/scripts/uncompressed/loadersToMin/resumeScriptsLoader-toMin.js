//RESUME SCRIPTS

// Load js
LazyLoad.js(['http://code.jquery.com/jquery-latest.min.js', 'scripts/resumeScripts.min.js'], function () {
	runAnimations(3);
	//delete script tags
	$("script").remove();
});