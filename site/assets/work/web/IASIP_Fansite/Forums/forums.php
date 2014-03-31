<?
include "header.php";
$dbconnection = mysql_connect("abtingramiancom.ipagemysql.com","gramian","L@kers13");

if (!$dbconnection)
	{
	die('problem connecting to the db');	
	}
mysql_select_db("agdatabase", $dbconnection); 
?>
<table align="center" width="80%" id="Forum_Listings">
<?php
if($membertype=="Administrator")
{
?>
	<tr>
   		<td  colspan="3" style="border:none; padding:5px;" align="left">
       	<form action="new_forum.php" method="get">
		<input value="New Forum" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit">
		</form>
       	</td>
   	</tr>
<?php
}
?>
	<tr>
	<td width="80%" align="left">
	Forum
	</td>
	<td width="10%" align="center">
	Topics
	</td>
	<td width="10%" align="center">
	Posts
	</td>
	</tr>
    <?php
	$thesql = "SELECT * FROM forums ORDER BY forumID";
	$results = mysql_query($thesql);
	
	while ($currentrow = mysql_fetch_array($results))
	{
		echo "<tr> ";
		echo "<td style='padding:20px' align='left'>";
		echo "<a href='topics.php?f=" . $currentrow["forumID"] . "'>" . $currentrow["forumName"] . "</a>";
		echo "<br />";
		echo "<font size='-1' color='#666666'>" . $currentrow["forumTagline"] . "</font>";
		if($membertype=="Administrator")
		{
			echo "<form action='edit_forum.php' method='get'>";
			echo "<input value='Edit/Delete Forum' class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" type=\"submit\">";
        	echo "<input value=" . $currentrow["forumID"] . " type='hidden' name='f' />";
			echo "</form>";
		}
		echo "</td>";
		echo "<td align='center'>";
		echo $currentrow["numTopics"];
		echo "</td>";
		echo "<td align='center'>";
		echo $currentrow["numPosts"];
		echo "</td>";
		echo "</tr>";
	}
	?>
</table>
</center>

<noscript>
</body>
</html>
