<?php 
include "header.php";
?>
<table align="center" width="80%" id="Register">
	<tr>
	<td>
	Reply to Post
	</td>
	</tr>
    <tr>       
        <td style="border:none">
        <table align="center" width="70%" style="border: none">
        	<tr>
            	<td style="border:none" align="center">
    			<?php
				if(!isset($_SESSION["loggedin"]))
				{
					echo "You must login to reply to a post.";
					exit();
				}
				
				else if(isset($_REQUEST["complete_new_post"]))
				{
					if(empty($_REQUEST["postname"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a name for your post.</font>
    	                <br />
                <?php
					}

					if(empty($_REQUEST["message"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a message for your new post.</font>
    	                <br />
                <?php
					}			
				
					if(!empty($_REQUEST["postname"]) && !empty($_REQUEST["message"]))
					{
						$thesql = "INSERT INTO posts
		   							(topicID, postName, userName, postMessage)
				   					VALUES
							   		(" . $_REQUEST["t"] . ", '" . addslashes($_REQUEST["postname"]) . "', '" 
									   . addslashes($_SESSION["loggedin"]) . "', '" 
									   . nl2br(addslashes($_REQUEST["message"])) . "')";
						mysql_query($thesql);
						$thesql = "SELECT postDate FROM posts 
										WHERE userName = '" .  addslashes($_SESSION["loggedin"]) . "' AND" .
											" postName = '" .  addslashes($_REQUEST["postname"]) . "' AND" .
											" topicID = " . $_REQUEST["t"] . 
											" AND postMessage = '" . nl2br(addslashes($_REQUEST["message"])) . "'";					
						
						$results = mysql_query($thesql);
						$currentrow = mysql_fetch_array($results);
						$postDate = $currentrow["postDate"];
						
						$thesql = "UPDATE topics SET lastPost = '" . $postDate . "'," .
										" numReplies = numReplies + 1 " .
										" WHERE topicID = " . $_REQUEST["t"];					
						mysql_query($thesql);
						
						$thesql = "UPDATE users SET numPosts = numPosts + 1 " .
										" WHERE userName = '" . addslashes($_SESSION["loggedin"]) . "'";					
						mysql_query($thesql);
						
						$thesql = "UPDATE forums SET numPosts = numPosts + 1 
										WHERE forumID = '" . $_REQUEST["f"] . "'";					
						mysql_query($thesql);
						
						echo "<center>Your reply was successfully posted!</center>";
						exit();
					}
				}
				?>                
                </td>
            </tr>
            <tr>
                <td style="border:none">
                
                <table align="center" style="border: none">            
                    <form action="" method="get">
                    <tr>
                        <td style="border:none">
                		Title:
                		<br />
                		<input size="60"  name="postname" type="text" class="text">
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                        Message:
                		<br />
                        <textarea name = "message" rows="20" cols="80" wrap="soft"></textarea>
                        </td>
                	</tr>                    
                	<tr>
                		<td align="center" style="border:none">
                        <br />
                		<input value="Submit Reply" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> <input value="Reset Fields" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="Reset">
                        </td>
                    </tr> 
                    <input type="hidden" name="complete_new_post" value="yes" />
                    <input value="<?php echo $_REQUEST["f"]; ?>" type="hidden" name="f" />
                    <input value="<?php echo $_REQUEST["t"]; ?>" type="hidden" name="t" />
        			</form>                                     
                </table>
                </td>
            </tr>                    
        </table>

        </td>
    </tr>
</table>
</center>

<noscript>
</body>
</html>
