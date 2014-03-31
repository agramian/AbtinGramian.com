//Change values to letters corresponding to character names, and make funtion to check substring and count number of letters
//for each character and add points accordingly depending on number of that character's first letter in the value
function checkResults() {
var questions = new Array
questions[0] = document.Quiz.Pet
questions[1] = document.Quiz.Song
questions[2] = document.Quiz.Talent
questions[3] = document.Quiz.Drug
questions[4] = document.Quiz.Weapon
questions[5] = document.Quiz.Food
questions[6] = document.Quiz.Clothing
questions[7] = document.Quiz.Costume
questions[8] = document.Quiz.Transportation
questions[9] = document.Quiz.Accessory
questions[10] = document.Quiz.Insecurity
questions[11] = document.Quiz.Escape
questions[12] = document.Quiz.Mate
questions[13] = document.Quiz.Crew
questions[14] = document.Quiz.Dance
questions[15] = document.Quiz.About
questions[16] = document.Quiz.Pressure

var character = new Array
character[0] = 0 //Mac
character[1] = 0 //Charlie
character[2] = 0 //Dennis
character[3] = 0 //Dee
character[4] = 0 //Frank

var answered = 0

for(i = 0; i<questions.length;i++)
{	
	for(j = 0; j < questions[i].length; j++) {
		
		if(questions[i][j].checked) {
			s = questions[i][j].value
			answered++
			for(k = 0; k < s.length; k++)
			{
				if(s.charAt(k) == 'm')
					character[0]++
				if(s.charAt(k) == 'c')
					character[1]++
				if(s.charAt(k) == 'd')
					character[2]++
				if(s.charAt(k) == 's')
					character[3]++
				if(s.charAt(k) == 'f')
					character[4]++					
			}
		}
	}
}
if(answered == questions.length)
{
	for(i = 0; i <character.length; i++)
	{
		for(j = 0; j < character.length; j++)
		{
			if(character[i]!=character[j])
			{
				if(character[i]>character[j])
				{
					character[j] = -1;
				}
				if(character[i]==character[j])
				{
					character[i] = 0
					character[j] = 0
				}
			}
		}
	}
	result = ""
	if(character[0]>=0)
		result += "m"
	if(character[1]>=0)
		result += "c"
	if(character[2]>=0)
		result += "d"
	if(character[3]>=0)
		result += "s"
	if(character[4]>=0)
		result += "f"	

	for(i=0;i<result.length;i++)
	{
		if(result.charAt(i)=='m')
		{
			alert("Mac")
		}
		if(result.charAt(i)=='c')
		{
			alert("Charlie")			
		}
		if(result.charAt(i)=='s')
		{
			alert("Dee")
		}
		if(result.charAt(i)=='d')
		{
			alert("Dennis")
		}

		if(result.charAt(i)=='f')
		{
			alert("Frank")
		}
	}
}
else
{
	alert("Please answer all the questions to receive your result.");
}
}
