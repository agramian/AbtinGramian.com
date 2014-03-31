<?php
if(strpos($_SERVER["SCRIPT_NAME"],"security.php"))
		{ exit("You do not belong here."); }

if(empty($_SESSION["loggedin"])) 
{	
    if(empty($_REQUEST["password"]) && empty($_REQUEST["username"]))
    {
?>
	<table align="center" style="border:none">
    	<form action="" method="get">
       		<tr>
           		<td style="border:none">
               	User Name
               	</td>
               	<td style="border:none">
               	<input name="username" type="text" class="text">
               	</td>
               	<td style="border:none">
               	</td>
           	</tr>
           	<tr>
           		<td style="border:none">
               	Password
               	</td>
               	<td style="border:none">
               	<input name="password" type="password" class="text">
               	</td>
               	<td style="border:none">
               	<input value="Log in" type="submit" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'">
               	</td>
           	</tr>
            <?php
			if($currentpage=="topics.php" || $currentpage=="new_topic.php" || $currentpage=="new_post.php" || $currentpage=="posts.php")
			{
				echo "<input value='" . $_REQUEST["f"] . "' type='hidden' name='f' />";
			}
			if($currentpage=="new_post.php" || $currentpage=="posts.php")
			{
				echo "<input value='" . $_REQUEST["t"] . "' type='hidden' name='t' />";
			}
			if($currentpage=="search.php" && isset($_REQUEST["search"]))
			{
				echo "<input value='" . $_REQUEST["keywordsearch"] . "' type='hidden' name='keywordsearch' />";
				echo "<input value='" . $_REQUEST["forum"] . "' type='hidden' name='forum' />";
				echo "<input value='" . $_REQUEST["search"] . "' type='hidden' name='search' />";
			}
			?>
        </form>
    </table>
<?php
	}
	
	else 
	{
		$correct_login = '';
		
		$thesql = "SELECT * FROM users WHERE userName = '" . addslashes($_REQUEST["username"]) . "'";
		
		$results = mysql_query($thesql);

		if (!$results)
		{
			$correct_login = 'false';
		}
		if($results)
		{
			while ($currentrow = mysql_fetch_array($results))
			{ 
				if($currentrow["userPassword"] == $_REQUEST["password"]) 
				{
					$correct_login = 'true';
					$membertype = $currentrow["memberType"];
					break;
				}
			}
		}

		if($correct_login == 'true')
		{
		$_SESSION['loggedin'] = addslashes($_REQUEST["username"]);
?>
        	<table align="center" style="border:none; text-align:center">
        		<tr>
            		<td style="border:none">
               		Welcome <?php echo $_SESSION["loggedin"];?>!
               		</td>
            	</tr>
    			<tr>
    				<td style="border:none">
        				<a href="account_settings.php">Account Settings</a>
        			</td>
    			</tr>
                <?php if($membertype=="Administrator")
						{
				?>
                <tr>
    				<td style="border:none">
        				<a href="administration.php">Administration</a>
        			</td>
    			</tr>   
				<?php
						}
				?>
            	<tr>
            		<td style="border:none">
                	<form action="" method="get">
                	<input type="submit" value="Log out" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" onclick="window.location = 'forums.php?logout=yes';return false;">
                    <?php
					if($currentpage=="topics.php" || $currentpage=="new_topic.php" || $currentpage=="new_post.php" || $currentpage=="posts.php")
					{
						echo "<input value='" . $_REQUEST["f"] . "' type='hidden' name='f' />";
					}
					if($currentpage=="new_post.php" || $currentpage=="posts.php")
					{
						echo "<input value='" . $_REQUEST["t"] . "' type='hidden' name='t' />";
					}
					if($currentpage=="search.php" && isset($_REQUEST["search"]))
					{	
						echo "<input value='" . $_REQUEST["keywordsearch"] . "' type='hidden' name='keywordsearch' />";
						echo "<input value='" . $_REQUEST["forum"] . "' type='hidden' name='forum' />";
						echo "<input value='" . $_REQUEST["search"] . "' type='hidden' name='search' />";
					}
					?>
                	</form>
                	</td>
            	</tr>
        	</table>
<?php
		}
		else
		{
?>
        	<table align="center" style="border:none">
    			<form action="" method="get">
        		<tr>
            		<td style="border:none">
                	User Name
                	</td>
                	<td style="border:none">
                	<input name="username" type="text" class="text">
                	</td>
                	<td style="border:none">
                    <font color="#FF0000" size="-1">
                    Incorrect username or password.
                    <br />
                    <a style="color:#00F" href="forgot.php"><u>Forgot your username or password?</u></a>
                    </font>
                	</td>
            	</tr>
            	<tr>
            		<td style="border:none">
                	Password
                	</td>
                	<td style="border:none">
                	<input name="password" type="password" class="text">
                	</td>
                	<td style="border:none">
                	<input value="Log in" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit">
                    <?php
					if($currentpage=="topics.php" || $currentpage=="new_topic.php" || $currentpage=="new_post.php" || $currentpage=="posts.php")
					{
						echo "<input value='" . $_REQUEST["f"] . "' type='hidden' name='f' />";
					}
					if($currentpage=="new_post.php" || $currentpage=="posts.php")
					{
						echo "<input value='" . $_REQUEST["t"] . "' type='hidden' name='t' />";
					}
					if($currentpage=="search.php" && isset($_REQUEST["search"]))
					{		
						echo "<input value='" . $_REQUEST["keywordsearch"] . "' type='hidden' name='keywordsearch' />";
						echo "<input value='" . $_REQUEST["forum"] . "' type='hidden' name='forum' />";
						echo "<input value='" . $_REQUEST["search"] . "' type='hidden' name='search' />";
					}
					?>
                	</td>
            	</tr>
        	</form>
        </table>
<?php
		}
	}
}
else
{
?>
<table align="center" style="border:none; text-align:center">
	<tr>
   		<td style="border:none">
   		Welcome <?php echo $_SESSION["loggedin"];?>!
   		</td>
   	</tr>
    <tr>
    	<td style="border:none">
        	<a href="account_settings.php">Account Settings</a>
        </td>
    </tr>
    <?php 
	if($membertype=="Administrator")
	{
	?>
    <tr>
    	<td style="border:none">
    	<a href="administration.php">Administration</a>
    	</td>
    </tr>   
	<?php
	}
	?>    
   	<tr>
   		<td style="border:none">
       	<form action="" method="get">
       	<input type="submit" value="Log out" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" onclick="window.location = 'forums.php?logout=yes';return false;">
        <?php
		if($currentpage=="topics.php" || $currentpage=="new_topic.php" || $currentpage=="new_post.php" || $currentpage=="posts.php")
		{
			echo "<input value='" . $_REQUEST["f"] . "' type='hidden' name='f' />";
		}
		if($currentpage=="new_post.php" || $currentpage=="posts.php")
		{
			echo "<input value='" . $_REQUEST["t"] . "' type='hidden' name='t' />";
		}
		if($currentpage=="search.php" && isset($_REQUEST["search"]))
		{
			echo "<input value='" . $_REQUEST["keywordsearch"] . "' type='hidden' name='keywordsearch' />";
			echo "<input value='" . $_REQUEST["forum"] . "' type='hidden' name='forum' />";
			echo "<input value='" . $_REQUEST["search"] . "' type='hidden' name='search' />";
		}
		?>
       	</form>
       	</td>
   	</tr>
</table>
<?php
}
?>