//Dynamic Layer use with "The Gang" page
var left = new Array ; var top = new Array; var pic = new Array;

left[0] = '40%' ; top[0] = '-335px'; pic[0] = "<img src='mac_character_card.png' width='523' height='670' alt='Mac_card' />"
left[1] = '30%' ; top[1] = '-335px'; pic[1] = "<img src='dennis_character_card.png' width='523' height='670' alt='Mac_card' />"
left[2] = '30%' ; top[2] = '-335px'; pic[2] = "<img src='dee_character_card.png' width='523' height='670' alt='Mac_card' />"
left[3] = '50%' ; top[3] = '-335px'; pic[3] = "<img src='charlie_character_card.png' width='523' height='670' alt='Mac_card' />"
left[4] = '60%' ; top[4] = '-335px'; pic[4] = "<img src='frank_character_card.png' width='523' height='670' alt='Mac_card' />"

// detects for .all or .getElementById and returns appropriate obj
function getLayerObject(obj)
{
	if (document.all)
		return document.all(obj)
	if (document.getElementById)
		return document.getElementById(obj)
}

function hide()
{
	currentobj = getLayerObject("Card_div")
	currentobj.style.visibility = 'hidden'
	currentobj = getLayerObject("Close_div")
	currentobj.style.visibility = 'hidden'
}
	
function show(layername)
{
	l = "l"
	t = "t"
	
	if(layername == "Mac")
	{
		l = left[0]
		t = top[0]
		document.getElementById("Card_div").innerHTML = pic[0] 
	}
	
	if(layername == "Dennis")
	{
		l = left[1]
		t = top[1]
		document.getElementById("Card_div").innerHTML = pic[1]
	}

	if(layername == "Dee")
	{
		l = left[2]
		t = top[2]
		document.getElementById("Card_div").innerHTML = pic[2]
	}

	if(layername == "Charlie")
	{
		l = left[3]
		t = top[3]
		document.getElementById("Card_div").innerHTML = pic[3]
	}

	if(layername == "Frank")
	{
		l = left[4]
		t = top[4]
		document.getElementById("Card_div").innerHTML = pic[4] 
	}
	
	currentobj = getLayerObject("Card_div")
	currentobj.style.left = l
	currentobj.style.top = t
	currentobj.style.visibility = 'visible'
	
	currentobj = getLayerObject("Close_div")
	currentobj.style.visibility = 'visible'
	currentobj.style.left = l
}
	