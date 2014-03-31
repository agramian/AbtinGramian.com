<?php 
include "header.php";
?>
<table align="center" width="80%" id="Register">
	<tr>
	<td>
	Post New Topic
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
					echo "You must login to post a new topic.";
					exit();
				}
				
				else if(isset($_REQUEST["complete_new_topic"]))
				{
					if(empty($_REQUEST["topicname"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a name for your topic.</font>
    	                <br />
                <?php
					}

					if(empty($_REQUEST["message"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a message for your new topic.</font>
    	                <br />
                <?php
					}			
				
					if(!empty($_REQUEST["topicname"]) && !empty($_REQUEST["message"]))
					{
						$thesql = "INSERT INTO topics
		   							(forumID, topicName, userName)
				   					VALUES
							   		(" . $_REQUEST["f"] . ", '" . addslashes($_REQUEST["topicname"]) . "', '" 
									   . addslashes($_SESSION["loggedin"]) . "')";
		   
						mysql_query($thesql);
						$thesql = "SELECT topicID FROM topics 
										WHERE userName = '" .  addslashes($_SESSION["loggedin"]) . "' AND" .
											" topicName = '" . addslashes($_REQUEST["topicname"]) . "' AND" .
											" forumID = " . $_REQUEST["f"];
						$results = mysql_query($thesql);
						$currentrow = mysql_fetch_array($results);
						$topicID = $currentrow["topicID"];
						$thesql = "INSERT INTO posts
		   							(topicID, postName, userName, postMessage, topicFirstPost)
				   					VALUES
							   		(" . $topicID . ", '" . addslashes($_REQUEST["topicname"]) . "', '" 
									   . addslashes($_SESSION["loggedin"]) . "', '" 
									   . nl2br(addslashes($_REQUEST["message"])) . "', 1)";
						mysql_query($thesql);
						$thesql = "SELECT postDate FROM posts 
										WHERE userName = '" .  addslashes($_SESSION["loggedin"]) . "' AND" .
											" postName = '" .  addslashes($_REQUEST["topicname"]) . "' AND" .
											" topicID = " . $topicID . " AND 
											  postMessage = '" . nl2br(addslashes($_REQUEST["message"])) . "'";					
						
						$results = mysql_query($thesql);
						$currentrow = mysql_fetch_array($results);
						$postDate = $currentrow["postDate"];
						
						$thesql = "UPDATE topics SET lastPost = '" . $postDate .
										"' WHERE topicID = " . $topicID;					
						mysql_query($thesql);
						
						$thesql = "UPDATE users SET topicsStarted = topicsStarted + 1,
										numPosts = numPosts + 1 
										WHERE userName = '" . addslashes($_SESSION["loggedin"]) . "'";					
						mysql_query($thesql);
						
						$thesql = "UPDATE forums SET numTopics = numTopics + 1,
										numPosts = numPosts + 1 
										WHERE forumID = '" . $_REQUEST["f"] . "'";					
						mysql_query($thesql);
						
						echo "<center>Your new topic was successfully posted!</center>";
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
                		<input size="60"  name="topicname" type="text" class="text">
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
                		<input value="Submit New Topic" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> <input value="Reset Fields" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="Reset">
                        </td>
                    </tr> 
                    <input type="hidden" name="complete_new_topic" value="yes" />
                    <input value="<?php echo $_REQUEST["f"]; ?>" type="hidden" name="f" />
        			</form>                                     
                </table>
                </td>
            </tr>                    
        </table>

        </td>
    </tr>
</table>
</center>
