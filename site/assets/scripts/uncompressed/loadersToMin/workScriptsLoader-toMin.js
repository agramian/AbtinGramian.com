//WORK SCRIPTS LOADER
// Load js
LazyLoad.js(['http://code.jquery.com/jquery-latest.min.js', 'scripts/workScripts-Primary.min.js'], function () {
	$("#gallery").hide();
	runAnimations(2);
	//load secondary css
    LazyLoad.css("styles/AGStylesWork.min.css");
	//load secondary js
	LazyLoad.js('scripts/workScripts-Secondary.min.js',function() {
        //delete script tags
        $("script").remove();	    
	});
});