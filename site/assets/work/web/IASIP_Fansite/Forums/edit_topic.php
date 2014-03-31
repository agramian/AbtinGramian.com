<?
include "header.php";

if(!isset($_SESSION["loggedin"]) || $membertype != "Administrator")
{
?>
	<script language="javascript">	
		window.location = "topics.php";
	</script>
<?php 
exit();
}
?>
<table align="center" width="80%" id="Register">
	<tr>
	<td align="left">
	Edit/Delete Topic
	</td>
	</tr>
    <tr>       
        <td style="border:none">
        <table align="center" width="70%" style="border: none">
        	<tr>
            	<td style="border:none" align="center">
    			<?php
				if(isset($_REQUEST["delete_topic"]))
				{
					$thesql = "DELETE FROM topics 
									WHERE topicID = " . $_REQUEST["t"];	
					mysql_query($thesql);					
					echo "<center>The topic was successfully deleted!</center>";
					exit();
				}
				else if(isset($_REQUEST["edit_topic"]))
				{
					if(empty($_REQUEST["topicname"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a name for the topic.</font>
    	                <br />
                <?php
					}
					
					if(empty($_REQUEST["message"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a message for the topic.</font>
    	                <br />
                <?php
					}			
				
					if(!empty($_REQUEST["topicname"]) && !empty($_REQUEST["message"]))
					{	
						$thesql = "UPDATE topics 
									SET topicName = '" . addslashes($_REQUEST["topicname"]) . "'
									WHERE topicID = " . $_REQUEST["t"];	
						mysql_query($thesql);
						
						$thesql = "UPDATE posts 
									SET postName = '" . addslashes($_REQUEST["topicname"]) . "',
										postMessage = '" . nl2br(addslashes($_REQUEST["message"])) . "'
									WHERE topicID = " . $_REQUEST["t"] . " AND topicFirstPost=1";	
						mysql_query($thesql);
						
						echo "<center>The topic was successfully updated!</center>";
						echo "<br />";
					}
				}
				?>                
                </td>
            </tr>
            <tr>
                <td style="border:none">
                <?php
				$postsql = "SELECT postMessage FROM posts 
										WHERE topicID = " . $_REQUEST["t"];					
				$results = mysql_query($postsql);
				$currentrow = mysql_fetch_array($results);
				$topicMessage = $currentrow["postMessage"];
				
				$thesql = "SELECT * FROM topics WHERE topicID = " . $_REQUEST["t"];
				$results = mysql_query($thesql);
				$currentrow = mysql_fetch_array($results); 
				?>
                <table align="center" style="border: none">            
                    <form action="" method="get">
                    <tr>
                        <td style="border:none">
                		Title:
                		<br />
                		<input size="60"  name="topicname" type="text" class="text" value="<?php echo $currentrow["topicName"]; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                        message:
                		<br />
                        <textarea name = "message" rows="20" cols="80" wrap="soft"><?php echo $topicMessage; ?></textarea>
                        </td>
                	</tr>                    
                	<tr>
                		<td align="center" style="border:none">
                        <br />
                		<input value="Edit Topic" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> 
                        <input type="hidden" name="edit_topic" value="yes" />
                        <input type="hidden" name="f" value="<?php echo $_REQUEST['f']; ?>" />
                        <input type="hidden" name="t" value="<?php echo $_REQUEST['t']; ?>" />
        			</form>
                        </td>
                    </tr> 
                    <tr>
                    	<td align="center" style="border:none">
                        <br />
                    	<form action="" method="get">
                    	<input value="Delete Topic" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> 
                    	<input type="hidden" name="delete_topic" value="yes" />
                        <input type="hidden" name="f" value="<?php echo $_REQUEST['f']; ?>" />
                        <input type="hidden" name="t" value="<?php echo $_REQUEST['t']; ?>" />
                    </form>
                    	</td>
                    </tr>                                
                </table>
                </td>
            </tr>                    
        </table>

        </td>
    </tr>
</table>
</center>
