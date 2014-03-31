<?php 
include "header.php";
$dbconnection = mysql_connect("abtingramiancom.ipagemysql.com","gramian","L@kers13");

if (!$dbconnection)
	{
	die('problem connecting to the db');	
	}

mysql_select_db("agdatabase", $dbconnection); 

$thesql = "UPDATE topics SET numViews = numViews + 1" .
					" WHERE topicID = " . $_REQUEST["t"];					
mysql_query($thesql);

$thesql = "SELECT * FROM posts WHERE topicID = " . $_REQUEST["t"] . " ORDER BY topicID";

$results = mysql_query($thesql);

if(empty($_REQUEST["start"]))
	{ $start=1; }
else
	{ $start = $_REQUEST["start"]; }
$resultsPerPage = 5;
$end = $start + $resultsPerPage - 1;

if (mysql_num_rows($results) < $end)
	{ $end = mysql_num_rows($results); }
	
$counter = $start;

?>
<table align="center" width="80%" id="Posts_Listing">
	<tr>
    	<td  colspan="4" style="border:none; padding:5px;" align="left">
        <form action="new_post.php" method="get">
		<input value="Post Reply" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit">
        <input value="<?php echo $_REQUEST["t"]; ?>" type="hidden" name="t" />
        <input value="<?php echo $_REQUEST["f"]; ?>" type="hidden" name="f" />
		</form>
        </td>
    </tr>	
<?php 
include "next_previous.php";

if(mysql_num_rows($results)>0)
{
	mysql_data_seek($results,$start-1);

	while ($currentrow = mysql_fetch_array($results))
	{
		$usersql = "SELECT * FROM users WHERE userName = '" . addslashes($currentrow["userName"]) . "'";
		$userresults = mysql_query($usersql);
		$userrow = mysql_fetch_array($userresults);
		echo "<tr>";
		echo "<td style='border-bottom:none;padding:20px;' align='center'>";
		echo "<table width='99%' id='" . $currentrow["postID"] . "' >";
		
		echo "<tr>";
		echo "<td style='border-right:none;background-color:#999;padding:5px;' align='left'>";
		echo "<font size='-1'>" . $currentrow["postDate"] . "</font>";
		
		if($membertype=="Administrator" && $currentrow["topicFirstPost"]!=1)
		{
        	echo "<form action='edit_post.php' method='get'>";
			echo "<input value='Edit/Delete Post' class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" type=\"submit\">";
        	echo "<input value=" . $currentrow["postID"] . " type='hidden' name='p' />";
			echo "<input value=" . $currentrow["topicID"] . " type='hidden' name='t' />";
			echo "<input value=" . $_REQUEST["f"] . " type='hidden' name='f' />";
			echo "</form>";
		}
		
		echo "</td>";
		echo "<td style='border-right:none;border-left:none;background-color:#999;padding:5px;' align='left'>";
		echo "</td>";
		echo "<td style='border-left:none;background-color:#999;padding:5px;' align='right'>";
		echo "<font size='-1'>" . "#" . $counter . "</font>";
		echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		if(!empty($userrow["userPic"]))
		{
			echo "<td width='90px' style='border-right:none;padding:5px;' align='left' >";
			echo "<img width='80px' src='userPics/" . $userrow["userPic"] . "' />";
			echo "</td>";
			echo "<td style='border-right:none;border-left:none;padding:5px;' align='left' >";
			echo $currentrow["userName"];
			echo "<br />";
			echo "<font color=#444 size='-1'>" . $userrow["memberType"] . "</font>";
			echo "</td>";
		}
		else
		{
			echo "<td width='90px' style='border-right:none;padding:5px;' align='left' >";
			echo $currentrow["userName"];
			echo "<br />";
			echo "<font color=#444 size='-1'>" . $userrow["memberType"] . "</font>";
			echo "</td>";
			echo "<td style='border-right:none;border-left:none;padding:5px;' align='left' >";
			echo "</td>";
		}
		echo "<td style='border-left:none;padding:5px;' align='right'>";
		echo "<font color=#444 size='-1'>Join Date: " . date('M Y',strtotime($userrow["joinDate"]));
		echo "<br/>Posts: " . $userrow["numPosts"] . "</font>";
		echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td colspan='3' style='padding:5px;' align='left'>";
		echo "<font color=#444 size='-1'>" . $currentrow["postName"] . "</font>";
		echo "</td>";
		echo "</tr>";
		
		echo "<tr>";
		echo "<td colspan='3' style='border:none;padding:5px 5px 40px 5px;' align='left'>";
		echo $currentrow["postMessage"];
		echo "<br />";
		if(!empty($userrow["userSignature"]))
			echo $userrow["userSignature"];
		echo "</tr>";
		
		echo "</table>";
		echo "</td>";
		echo "</tr>";	
		
		if($counter==$end)
		{ break; }
		
		$counter ++;

	}
}
?>
</table>
