<?php 
include "header.php";
$dbconnection = mysql_connect("abtingramiancom.ipagemysql.com","gramian","L@kers13");

if (!$dbconnection)
	{
	die('problem connecting to the db');	
	}

mysql_select_db("agdatabase", $dbconnection); 

$thesql = "SELECT * FROM topics WHERE forumID = " . $_REQUEST["f"];
if(!isset($_REQUEST["sort"]))
	$_REQUEST["sort"] = 'topicid';
if($_REQUEST["sort"] == 'topicid')
{
	$thesql .= " ORDER BY topicID";
}
else if($_REQUEST["sort"] == 'topicname')
{
	$thesql .= " ORDER BY topicName";
}
else if($_REQUEST["sort"] == 'lastpost')
{
	$thesql .= " ORDER BY lastPost DESC";
}
else if($_REQUEST["sort"] == 'replies')
{
	$thesql .= " ORDER BY numReplies DESC";
}
else if($_REQUEST["sort"] == 'views')
{
	$thesql .= " ORDER BY numViews DESC";
}

$results = mysql_query($thesql);

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
<table align="center" width="80%" id="Topics_Listing">
	<tr>
    	<td  colspan="4" style="border:none; padding:5px;" align="left">
        <form action="new_topic.php" method="get">
		<input value="New Topic" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit">
        <input value="<?php echo $_REQUEST["f"]; ?>" type="hidden" name="f" />
		</form>
        </td>
    </tr>	
	<?php include "next_previous.php"; ?>
	<tr>
	<td width="60%" align="left" style="padding:5px;">
	<a href="topics.php?sort=topicname&f=<?php echo $_REQUEST["f"]; ?>"><u>Topic</u></a>
	</td>
	<td width="20%" align="center" style="padding:5px;">
	<a href="topics.php?sort=lastpost&f=<?php echo $_REQUEST["f"]; ?>"><u>Last Post</u></a>
	</td>
	<td width="10%" align="center" style="padding:5px;">
	<a href="topics.php?sort=replies&f=<?php echo $_REQUEST["f"]; ?>"><u>Replies</u></a>
	</td>
    <td width="10%" align="center" style="padding:5px;">
	<a href="topics.php?sort=views&f=<?php echo $_REQUEST["f"]; ?>"><u>Views</u></a>
	</td>
	</tr>
<?php
if(mysql_num_rows($results)>0)
{
	mysql_data_seek($results,$start-1);

	while ($currentrow = mysql_fetch_array($results))
	{
		echo "<tr> ";
		echo "<td align='left' style='padding:5px;'>";
		echo "<a href='posts.php?f=" . $_REQUEST["f"] . "&t=" . $currentrow["topicID"] . "'>" . $currentrow["topicName"] . "</a>";
		echo "<br /><font size='-1' color=#666>By: " . $currentrow["userName"] . "</font>";
		if($membertype=="Administrator")
		{
        	echo "<form action='edit_topic.php' method='get'>";
			echo "<input value='Edit/Delete Topic' class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" type=\"submit\">";
        	echo "<input value=" . $currentrow["topicID"] . " type='hidden' name='t' />";
			echo "<input value=" . $currentrow["forumID"] . " type='hidden' name='f' />";
			echo "</form>";
		}
		echo "</td>";
		echo "<td align='center' style='padding:5px;'>";
		echo $currentrow["lastPost"];
		echo "</td>";
		echo "<td align='center' style='padding:5px;'>";
		echo $currentrow["numReplies"];
		echo "</td>";
		echo "<td align='center' style='padding:5px;'>";
		echo $currentrow["numViews"];
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
