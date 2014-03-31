<?php 
if($start != 1 || $end < mysql_num_rows($results))
{
?>
	<tr>
	<td style="background-color:#CCCCCC;" colspan="5" align="center">
<?php
}

if($start != 1)
{
?>
	<a href="<?php echo $currentpage . "?start=" . ($start-$resultsPerPage); ?>
<?php
	if($currentpage=="topics.php" || $currentpage=="posts.php")
	{
		echo "&f=" . $_REQUEST["f"];
	}
	if($currentpage=="posts.php")
	{
		echo "&t=" . $_REQUEST["t"];
	}
	if($currentpage=="members.php"||$currentpage=="topics.php"||$currentpage=="search.php")
	{
		echo "&sort=" . $_REQUEST["sort"];	
	}
	if($currentpage=="search.php")
		{
			echo "&keywordsearch=" . $_REQUEST["keywordsearch"];
			echo "&forum=" . $_REQUEST["forum"];
			echo "&search=" . $_REQUEST["search"];
		}
	echo "\">Previous Page</a>";
}
if($start != 1 && $end < mysql_num_rows($results))
	echo " | ";
if($end < mysql_num_rows($results))
	{
?>
	<a href="<?php echo $currentpage . "?start=" . ($start+$resultsPerPage); ?>
<?php
	if($currentpage=="topics.php" || $currentpage=="posts.php")
	{
		echo "&f=" . $_REQUEST["f"];
	}
	if($currentpage=="posts.php")
	{
		echo "&t=" . $_REQUEST["t"];
	}
	if($currentpage=="members.php"||$currentpage=="topics.php"||$currentpage=="search.php")
	{
		echo "&sort=" . $_REQUEST["sort"];	
	}
	if($currentpage=="search.php")
	{
			echo "&keywordsearch=" . $_REQUEST["keywordsearch"];
			echo "&forum=" . $_REQUEST["forum"];
			echo "&search=" . $_REQUEST["search"];
	}
	echo "\">Next Page</a>";
}	
if($start != 1 || $end < mysql_num_rows($results))
{
?>
	</td>
    </tr>
<?php
}	
?>