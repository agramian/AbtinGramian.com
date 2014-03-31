<?php 
include "header.php";

$thesql = "SELECT * FROM users";
if(isset($_REQUEST["membersearch"]))
{
	$thesql .= " WHERE userName LIKE '%" . $_REQUEST["membersearch"] . "%'";
}

if(!isset($_REQUEST["sort"]))
	$_REQUEST["sort"] = 'userid';
if($_REQUEST["sort"] == 'userid')
{
	$thesql .= " ORDER BY userID";
}
else if($_REQUEST["sort"] == 'username')
{
	$thesql .= " ORDER BY userName";
}
else if($_REQUEST["sort"] == 'posts')
{
	$thesql .= " ORDER BY numPosts DESC";
}
$results = mysql_query($thesql);

if (!$results)
	{
	echo $results . "<br /> <br />";	
	die('error returned from the sql/query');	
	}

if(empty($_REQUEST["start"]))
	{ $start=1; }
else
	{ $start = $_REQUEST["start"]; }
$resultsPerPage = 5;
$end = $start + $resultsPerPage-1;

if (mysql_num_rows($results) < $end)
	{ $end = mysql_num_rows($results); }
	
$counter = $start;
?>
<table align="center" width="80%">
<?php
include "next_previous.php";
?>
	<tr>
	<td width="70%" align="left" style="padding:5px;">
	<a href="members.php?sort=username"><u>User Name</u></a>
	</td>
	<td width="15%" align="center" style="padding:5px;">
	<a href="members.php?sort=posts"><u>Posts</u></a>
	</td>
	<td width="15%" align="center" style="padding:5px;">
	Picture
	</td>
	</tr>
<?php
if(isset($_REQUEST["search"]) && mysql_num_rows($results)<=0)
{
	echo "<tr><td colspan='3' align='center'>Your search did not return any results.</td></tr>";
}
if(mysql_num_rows($results)>0)
{
	mysql_data_seek($results,$start-1);

	while ($currentrow = mysql_fetch_array($results))
	{
		echo "<tr> ";
		echo "<td align='left' style='padding:5px;'>";
		echo $currentrow["userName"];
		echo "<br />";
		echo "<font color=#444 size='-1'>" . $currentrow["memberType"] . "</font>";
		if($membertype=="Administrator")
		{
			echo "<br />";
        	echo "<form action='edit_member.php' method='get'>";
			echo "<input value='Edit/Delete Member' class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" type=\"submit\">";
        	echo "<input value=" . $currentrow["userID"] . " type='hidden' name='u' />";
			echo "</form>";
		}
		echo "</td>";
		echo "<td align='center' style='padding:5px;'>";
		echo $currentrow["numPosts"];
		echo "</td>";
		echo "<td align='center' style='padding:5px;'>";
		if(!empty($currentrow["userPic"]))
			echo "<img width='80px' src='userPics/" . $currentrow["userPic"] . "' />";
		echo "</td>";
		echo "</tr>";

		if($counter==$end)
		{ break; }
		
		$counter ++;

	}
}

include "next_previous.php";
?>
</table>
