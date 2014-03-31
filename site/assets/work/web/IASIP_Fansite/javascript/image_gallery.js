var cell_1_pic;
var macGallery = false;
var bColor = "#000";

function getMacGallery(name)
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
		if(unescape(document.cookie.substring((j+1), cEnd)) == "Mac")
		{
		macGallery = true;
		}
		}
		i++	
	}
	if(cLen == 0 || !cEnd) {
		macGallery = true;
	}
}
function swap_images(start)
{
	if(macGallery)
		bColor = "#FFF";
	
	current_pic = 0;
	if(start<1)
		start = 329;
	if(start>329)
		start = 1;
	cell_1_pic = start;
	var newImg = new Image();
	for(i=start; i<start+6; i++)
	{
		newImg.src = "Images/sunny_"+i+".jpg";
		current_pic++;
		if(current_pic==1)
			document.getElementById("Image_1_Cell").innerHTML = "<img src='Images/sunny_"+i+".jpg' id='Img1' height='40'  onclick='enlarge_image(this);this.border=5;this.style.borderColor=\""+bColor+"\";'/>";
		else if(current_pic==2)
			document.getElementById("Image_2_Cell").innerHTML = "<img src='Images/sunny_"+i+".jpg' id='Img2' height='40' onclick='enlarge_image(this);this.border=5;this.style.borderColor=\""+bColor+"\";'/>";	
		else if(current_pic==3)
			document.getElementById("Image_3_Cell").innerHTML = "<img src='Images/sunny_"+i+".jpg' id='Img3' height='40' onclick='enlarge_image(this);this.border=5;this.style.borderColor=\""+bColor+"\";'/>";
		else if(current_pic==4)
			document.getElementById("Image_4_Cell").innerHTML = "<img src='Images/sunny_"+i+".jpg' id='Img4' height='40' onclick='enlarge_image(this);this.border=5;this.style.borderColor=\""+bColor+"\";'/>";
		else if(current_pic==5)
			document.getElementById("Image_5_Cell").innerHTML = "<img src='Images/sunny_"+i+".jpg' id='Img5' height='40' onclick='enlarge_image(this);this.border=5;this.style.borderColor=\""+bColor+"\";'/>";
		else if(current_pic==6)
			document.getElementById("Image_6_Cell").innerHTML = "<img src='Images/sunny_"+i+".jpg' id='Img6' height='40' onclick='enlarge_image(this);this.border=5;this.style.borderColor=\""+bColor+"\";'/>";
	}
}

function enlarge_image(img)
{
	if(img.id!="Img1")
		document.getElementById("Img1").border = 0;
	if(img.id!="Img2")
		document.getElementById("Img2").border = 0;
	if(img.id!="Img3")
		document.getElementById("Img3").border = 0;
	if(img.id!="Img4")
		document.getElementById("Img4").border = 0;
	if(img.id!="Img5")
		document.getElementById("Img5").border = 0;
	if(img.id!="Img6")
		document.getElementById("Img6").border = 0;		
	width = (500.0*img.width)/img.height;
	document.getElementById("Medium_Image").href = img.src;
	document.getElementById("Medium_Image").innerHTML = "<img src='"+img.src+"' height='500' onmouseover='this.style.borderColor = \"#666\";' onmouseout='this.style.borderColor = \""+bColor+"\";' style='border-color:"+bColor+";' />";
}