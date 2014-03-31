// when the page loads, check the cookie value "fav". if it does NOT exist, do your default stylesheet setups
// if it does exist, use the value (such as Dee) to turn on and off sheets
function getMac(name,bonus)
{
	var cookieLen = name.length
	var cLen = document.cookie.length
	var i = 0
	var cEnd
	
	while (i < cLen)
	{
		var j = i + cookieLen
		if (document.cookie.substring(i,j) == name)
		{	
		cEnd = document.cookie.indexOf(";",j)
		if (cEnd == -1)
		{ 
		cEnd = document.cookie.length 
		}
		whiteButtons(unescape(document.cookie.substring((j+1), cEnd)),bonus)
		}
		i++	
	}
	if(cLen == 0 || !cEnd) {
		whiteButtons("Mac",bonus)
	}
}
		
function whiteButtons(favCharacter,bonusPage)
{
	if(favCharacter == "Mac")
	{
		if(bonusPage=="bonus")
		{
			MM_preloadImages('../Buttons/home_white_selected.png','../Buttons/home__white_over.png','../Buttons/close_white_selected.png','../Buttons/close_white_over.png','../Buttons/character_quiz_white_selected.png','../Buttons/character_quiz_white_over.png');
			
			document.getElementById("Home_div").innerHTML = "<a href='../index.html' target='_top' onclick='MM_nbGroup(\"down\",\"group1\",\"Home\",\"../Buttons/home_white_selected.png\",1)' onmouseover='MM_nbGroup(\"over\",\"Home\",\"../Buttons/home_white_over.png\",\"../Buttons/home_white_selected.png\",1)' onmouseout='MM_nbGroup(\"out\")'><img src='../Buttons/home_white_normal.png' alt='Go to Home Page' name='Home' border='0' id='Home' onload='' /></a>";

			document.getElementById("Quiz_div").innerHTML = "<a href='quiz.html' target='_top' onClick='MM_nbGroup(\"down\",\"group1\",\"Quiz\",\"../Buttons/character_quiz_white_selected.png\",1)' onMouseOver='MM_nbGroup(\"over\",\"Quiz\",\"../Buttons/character_quiz_white_over.png\",\"../Buttons/character_quiz_white_selected.png\",1)' onMouseOut='MM_nbGroup(\"out\")'><img name='Quiz' src='../Buttons/character_quiz_white_normal.png' border='0' alt='Click to take the It's Always Sunny In Philadelphia Character Quiz to find out which member of 'The Gang' you are most similar to.' onLoad='' /></a>";

			document.getElementById("Close_div").innerHTML = "<a href='javascript:;' target='_top' onClick='MM_nbGroup(\"down\",\"group1\",\"Close\",\"../Buttons/close_white_selected.png\",1);MM_showHideLayers(\"Home_div\",\"\",\"show\",\"Quiz_div\",\"\",\"show\",\"RCH_1_div\",\"\",\"show\",\"RCH_2_div\",\"\",\"show\",\"RCH_3_div\",\"\",\"show\",\"RCH_Reverse_div\",\"\",\"show\",\"RCH_Reverse_Back_div\",\"\",\"hide\",\"RCH_1_R_div\",\"\",\"hide\",\"RCH_2_R_div\",\"\",\"hide\",\"RCH_3_R_div\",\"\",\"hide\",\"Close_div\",\"\",\"hide\",\"Close_R_div\",\"\",\"hide\",\"S1_div\",\"\",\"hide\",\"FLVPlayer\",\"\",\"hide\",\"S2_div\",\"\",\"hide\",\"FLVPlayer1\",\"\",\"hide\",\"S3_div\",\"\",\"hide\",\"FLVPlayer2\",\"\",\"hide\",\"S1_R_div\",\"\",\"hide\",\"FLVPlayer3\",\"\",\"hide\",\"S2_R_div\",\"\",\"hide\",\"FLVPlayer4\",\"\",\"hide\",\"S3_R_div\",\"\",\"hide\",\"FLVPlayer5\",\"\",\"hide\")' onMouseOver='MM_nbGroup(\"over\",\"Close\",\"../Buttons/close_white_over.png\",\"../Buttons/close_white_selected.png\",1)' onMouseOut='MM_nbGroup(\"out\")'><img name='Close' src='../Buttons/close_white_normal.png' border='0' alt='Close Video' onLoad='' /></a>";

			document.getElementById("Close_R_div").innerHTML = "<a href='#' target='_top' onClick='MM_nbGroup(\"down\",\"group1\",\"Close_R\",\"../Buttons/close_white_selected.png\",1);MM_showHideLayers(\"Home_div\",\"\",\"show\",\"Quiz_div\",\"\",\"show\",\"RCH_1_div\",\"\",\"hide\",\"RCH_2_div\",\"\",\"hide\",\"RCH_3_div\",\"\",\"hide\",\"RCH_Reverse_div\",\"\",\"hide\",\"RCH_Reverse_Back_div\",\"\",\"show\",\"RCH_1_R_div\",\"\",\"show\",\"RCH_2_R_div\",\"\",\"show\",\"RCH_3_R_div\",\"\",\"show\",\"Close_div\",\"\",\"hide\",\"Close_R_div\",\"\",\"hide\",\"S1_div\",\"\",\"hide\",\"FLVPlayer\",\"\",\"hide\",\"S2_div\",\"\",\"hide\",\"FLVPlayer1\",\"\",\"hide\",\"S3_div\",\"\",\"hide\",\"FLVPlayer2\",\"\",\"hide\",\"S1_R_div\",\"\",\"hide\",\"FLVPlayer3\",\"\",\"hide\",\"S2_R_div\",\"\",\"hide\",\"FLVPlayer4\",\"\",\"hide\",\"S3_R_div\",\"\",\"hide\",\"FLVPlayer5\",\"\",\"hide\")' onMouseOver='MM_nbGroup(\"over\",\"Close_R\",\"../Buttons/close_white_over.png\",\"../Buttons/close_white_selected.png\",1)' onMouseOut='MM_nbGroup(\"out\")'><img name='Close_R' src='../Buttons/close_white_normal.png' border='0' alt='Close Video' onLoad='' /></a>";
		}
		else
		{
			MM_preloadImages('../Buttons/home_white_selected.png','../Buttons/home_white_over.png');
			
			document.getElementById("Home_div").innerHTML = "<a href='../index.html' target='_top' onclick='MM_nbGroup(\"down\",\"group1\",\"Home\",\"../Buttons/home_white_selected.png\",1)' onmouseover='MM_nbGroup(\"over\",\"Home\",\"../Buttons/home_white_over.png\",\"../Buttons/home_white_selected.png\",1)' onmouseout='MM_nbGroup(\"out\")'><img src='../Buttons/home_white_normal.png' alt='Go to Home Page' name='Home' width='144' height='43' border='0' id='Home' onload='' /></a>";
		}
	}
	else 
	{
		if(bonusPage=="bonus")
		{
			MM_preloadImages('../Buttons/home_selected.png','../Buttons/home_over.png','../Buttons/close_selected.png','../Buttons/close_over.png');
			
			document.getElementById("Home_div").innerHTML = "<a href='../index.html' target='_top' onclick='MM_nbGroup(\"down\",\"group1\",\"Home\",\"../Buttons/home_selected.png\",1)' onmouseover='MM_nbGroup(\"over\",\"Home\",\"../Buttons/home_over.png\",\"../Buttons/home_selected.png\",1)' onmouseout='MM_nbGroup(\"out\")'><img src='../Buttons/home_normal.png' alt='Go to Home Page' name='Home' border='0' id='Home' onload='' /></a>";

			document.getElementById("Quiz_div").innerHTML = "<a href='quiz.html' target='_top' onClick='MM_nbGroup(\"down\",\"group1\",\"Quiz\",\"../Buttons/character_quiz_selected.png\",1)' onMouseOver='MM_nbGroup(\"over\",\"Quiz\",\"../Buttons/character_quiz_over.png\",\"../Buttons/character_quiz_selected.png\",1)' onMouseOut='MM_nbGroup(\"out\")'><img name='Quiz' src='../Buttons/character_quiz_normal.png' border='0' alt='Click to take the It's Always Sunny In Philadelphia Character Quiz to find out which member of 'The Gang' you are most similar to.' onLoad='' /></a>";

			document.getElementById("Close_div").innerHTML = "<a href='javascript:;' target='_top' onClick='MM_nbGroup(\"down\",\"group1\",\"Close\",\"../Buttons/close_selected.png\",1);MM_showHideLayers(\"Home_div\",\"\",\"show\",\"Quiz_div\",\"\",\"show\",\"RCH_1_div\",\"\",\"show\",\"RCH_2_div\",\"\",\"show\",\"RCH_3_div\",\"\",\"show\",\"RCH_Reverse_div\",\"\",\"show\",\"RCH_Reverse_Back_div\",\"\",\"hide\",\"RCH_1_R_div\",\"\",\"hide\",\"RCH_2_R_div\",\"\",\"hide\",\"RCH_3_R_div\",\"\",\"hide\",\"Close_div\",\"\",\"hide\",\"Close_R_div\",\"\",\"hide\",\"S1_div\",\"\",\"hide\",\"FLVPlayer\",\"\",\"hide\",\"S2_div\",\"\",\"hide\",\"FLVPlayer1\",\"\",\"hide\",\"S3_div\",\"\",\"hide\",\"FLVPlayer2\",\"\",\"hide\",\"S1_R_div\",\"\",\"hide\",\"FLVPlayer3\",\"\",\"hide\",\"S2_R_div\",\"\",\"hide\",\"FLVPlayer4\",\"\",\"hide\",\"S3_R_div\",\"\",\"hide\",\"FLVPlayer5\",\"\",\"hide\")' onMouseOver='MM_nbGroup(\"over\",\"Close\",\"../Buttons/close_over.png\",\"../Buttons/close_selected.png\",1)' onMouseOut='MM_nbGroup(\"out\")'><img name='Close' src='../Buttons/close_normal.png' border='0' alt='Close Video' onLoad='' /></a>";

			document.getElementById("Close_R_div").innerHTML = "<a href='#' target='_top' onClick='MM_nbGroup(\"down\",\"group1\",\"Close_R\",\"../Buttons/close_selected.png\",1);MM_showHideLayers(\"Home_div\",\"\",\"show\",\"Quiz_div\",\"\",\"show\",\"RCH_1_div\",\"\",\"hide\",\"RCH_2_div\",\"\",\"hide\",\"RCH_3_div\",\"\",\"hide\",\"RCH_Reverse_div\",\"\",\"hide\",\"RCH_Reverse_Back_div\",\"\",\"show\",\"RCH_1_R_div\",\"\",\"show\",\"RCH_2_R_div\",\"\",\"show\",\"RCH_3_R_div\",\"\",\"show\",\"Close_div\",\"\",\"hide\",\"Close_R_div\",\"\",\"hide\",\"S1_div\",\"\",\"hide\",\"FLVPlayer\",\"\",\"hide\",\"S2_div\",\"\",\"hide\",\"FLVPlayer1\",\"\",\"hide\",\"S3_div\",\"\",\"hide\",\"FLVPlayer2\",\"\",\"hide\",\"S1_R_div\",\"\",\"hide\",\"FLVPlayer3\",\"\",\"hide\",\"S2_R_div\",\"\",\"hide\",\"FLVPlayer4\",\"\",\"hide\",\"S3_R_div\",\"\",\"hide\",\"FLVPlayer5\",\"\",\"hide\")' onMouseOver='MM_nbGroup(\"over\",\"Close_R\",\"../Buttons/close_over.png\",\"../Buttons/close_selected.png\",1)' onMouseOut='MM_nbGroup(\"out\")'><img name='Close_R' src='../Buttons/close_normal.png' border='0' alt='Close Video' onLoad='' /></a>";
		}
		else
		{
			MM_preloadImages('../Buttons/home_selected.png','../Buttons/home_over.png');
			
			document.getElementById("Home_div").innerHTML = "<a href='../index.html' target='_top' onclick='MM_nbGroup(\"down\",\"group1\",\"Home\",\"../Buttons/home_selected.png\",1)' onmouseover='MM_nbGroup(\"over\",\"Home\",\"../Buttons/home_over.png\",\"../Buttons/home_selected.png\",1)' onmouseout='MM_nbGroup(\"out\")'><img src='../Buttons/home_normal.png' alt='Go to Home Page' name='Home' width='144' height='43' border='0' id='Home' onload='' /></a>";
		}
	}
}