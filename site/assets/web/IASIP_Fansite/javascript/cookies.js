// when the page loads, check the cookie value "fav". if it does NOT exist, do your default stylesheet setups
// if it does exist, use the value (such as Dee) to turn on and off sheets
function getCookie(name)
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
		changeBackground(unescape(document.cookie.substring((j+1), cEnd)))
		}
		i++	
	}
	if(cLen == 0 || !cEnd) {
		changeBackground("Mac");
	}
}
	
document.styleSheets[1].disabled=true;
document.styleSheets[2].disabled=true; 
document.styleSheets[3].disabled=true; 	
document.styleSheets[4].disabled=true; 
document.styleSheets[5].disabled=true;
		
function changeBackground(favCharacter)
{
	if(favCharacter == "Dee")
	{
		document.styleSheets[1].disabled=false;
	}
	else if(favCharacter == "Mac")
	{
		document.styleSheets[2].disabled=false;
	}
	else if(favCharacter == "Dennis")
	{
		document.styleSheets[3].disabled=false;
	}
	else if(favCharacter == "Charlie")
	{
		document.styleSheets[4].disabled=false;
	}
	else if(favCharacter == "Frank")
	{
		document.styleSheets[5].disabled=false;
	}
}