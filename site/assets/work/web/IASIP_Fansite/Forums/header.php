<?
session_start();
$membertype = "";
if(isset($_REQUEST["logout"])) {
	session_unset();
	session_destroy();
}
$dbconnection = mysql_connect("abtingramiancom.ipagemysql.com","gramian","L@kers13");
if (!$dbconnection)
{
die('problem connecting to the db');	
}
mysql_select_db("agdatabase", $dbconnection);

if(isset($_SESSION["loggedin"]))
{
	$thesql = "SELECT * FROM users WHERE userName = '" . addslashes($_SESSION["loggedin"]) . "'";
	$results = mysql_query($thesql);
	$currentrow = mysql_fetch_array($results);
	$membertype = $currentrow["memberType"];
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Forums</title>
<style type="text/css">
<!--
-->
</style>
<link rel="shortcut icon" href="../favicon.ico" type="image/x-icon"> 
<link href="../styles/Dee_style.css" rel="stylesheet" type="text/css" />
<link href="../styles/Mac_style.css" rel="stylesheet" type="text/css" />
<link href="../styles/Dennis_style.css" rel="stylesheet" type="text/css" />
<link href="../styles/Charlie_style.css" rel="stylesheet" type="text/css" />
<link href="../styles/Frank_style.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="../javascript/cookies.js"></script>

</head>

<body onload="getCookie('fav');">
<center>
<table align="center" width="80%" id="Forums_Title">
	<tr>
	<td align="center">
    <a href="../index.html">HOME</a> > <a href="forums.php">It's Always Sunny In Philadelphia Forums</a>
	</td>
	</tr>
</table>
<br />
<table align="center" width="80%" id="Navigation_Bar">
	<tr>
	<td width="33%" align="center">
    <a href="register.php">REGISTER</a>
	</td>
    <td width="34%" align="center">
    <a href="members.php">MEMBERS LIST</a>
	</td>
    <td width="33%" align="center">
    <a href="search.php">SEARCH</a>
	</td>
	</tr>
</table>
<br />
<table align="center" width="80%" id="Navigation_Bar_2">
	<tr>
	<td align="center">
    <a href="forums.php">IASIP Forums</a>
    <?php
	$currentpage = substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
	if($currentpage=="members.php")
	{
		echo " > <a href='members.php'>MEMBERS LIST</a>";
	}
	else if($currentpage=="register.php")
	{
		echo " > <a href='register.php'>REGISTER</a>";
	}
	else if($currentpage=="account_settings.php")
	{
		echo " > <a href='account_settings.php'>Account Settings</a>";
	}
	else if($currentpage=="administration.php")
	{
		echo " > <a href='administration.php'>Administration</a>";
	}
	else if($currentpage=="forgot.php")
	{
		echo " > <a href='forgot.php'>User Name and Password Recovery</a>";
	}
	else if($currentpage=="search.php")
	{
		echo " > <a href='search.php'>SEARCH</a>";
	}
	else if($currentpage=="topics.php" || $currentpage=="new_topic.php" || $currentpage=="edit_topic.php" || $currentpage=="edit_forum.php" || $currentpage=="posts.php" || $currentpage=="new_post.php" || $currentpage=="edit_post.php")
	{
		$thesql = "SELECT * FROM forums ORDER BY forumID";
		$results = mysql_query($thesql);
		
		while($currentrow = mysql_fetch_array($results))
		{
			if(isset($_REQUEST["f"]) && $currentrow["forumID"]==$_REQUEST["f"])
			{
				echo " > <a href='topics.php?f=" . $currentrow["forumID"] . "'>" . $currentrow["forumName"] . "</a>";
				break;
			}
		}
		
		if($currentpage=="edit_forum.php")
		{
			echo " > Edit/Delete Forum";
		}
		else if($currentpage=="new_topic.php")
		{
			echo " > Post New Topic";
		}
		else if($currentpage=="edit_topic.php")
		{
			echo " > Edit/Delete Topic";
		}
		else if($currentpage=="posts.php" || $currentpage=="new_post.php" || $currentpage=="edit_post.php")
		{
			echo " > <a href='posts.php?f=" . $_REQUEST["f"] . "&t=" . $_REQUEST["t"] . "'>";

			$thesql = "SELECT topicName FROM topics 
						WHERE topicID = " .  $_REQUEST["t"];
			$results = mysql_query($thesql);
			$currentrow = mysql_fetch_array($results);
			echo $currentrow["topicName"] . "</a>";

			if($currentpage=="new_post.php")
			{
				echo " > Reply to Topic";
			}
			else if($currentpage=="edit_post.php")
			{
				echo " > Edit/Delete Post";
			}
		}
	}
	?>
	</td>
    <td width="33%" align="center">
    <?php include "security.php";?>        
	</td>
	</tr>
</table>
<br />