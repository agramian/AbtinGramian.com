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
	Edit/Delete Post
	</td>
	</tr>
    <tr>       
        <td style="border:none">
        <table align="center" width="70%" style="border: none">
        	<tr>
            	<td style="border:none" align="center">
    			<?php
				if(isset($_REQUEST["delete_post"]))
				{
					$thesql = "DELETE FROM posts 
									WHERE postID = " . $_REQUEST["p"];	
					mysql_query($thesql);					
					echo "<center>The post was successfully deleted!</center>";
					exit();
				}
				else if(isset($_REQUEST["edit_post"]))
				{
					if(empty($_REQUEST["postname"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a name for the post.</font>
    	                <br />
                <?php
					}
					
					if(empty($_REQUEST["message"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a message for the post.</font>
    	                <br />
                <?php
					}			
				
					if(!empty($_REQUEST["postname"]) && !empty($_REQUEST["message"]))
					{				
						$thesql = "UPDATE posts 
									SET postName = '" . addslashes($_REQUEST["postname"]) . "',
										postMessage = '" . nl2br(addslashes($_REQUEST["message"])) . "'
									WHERE postID = " . $_REQUEST["p"];	
						mysql_query($thesql);
						
						echo "<center>The post was successfully updated!</center>";
						echo "<br />";
					}
				}
				?>                
                </td>
            </tr>
            <tr>
                <td style="border:none">
                <?php			
				$thesql = "SELECT * FROM posts WHERE postID = " . $_REQUEST["p"];
				$results = mysql_query($thesql);
				$currentrow = mysql_fetch_array($results); 
				?>
                <table align="center" style="border: none">            
                    <form action="" method="get">
                    <tr>
                        <td style="border:none">
                		Title:
                		<br />
                		<input size="60"  name="postname" type="text" class="text" value="<?php echo $currentrow["postName"]; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                        Message:
                		<br />
                        <textarea name = "message" rows="20" cols="80" wrap="soft"><?php echo $currentrow["postMessage"]; ?></textarea>
                        </td>
                	</tr>                    
                	<tr>
                		<td align="center" style="border:none">
                        <br />
                		<input value="Edit Post" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> 
                        <input type="hidden" name="edit_post" value="yes" />
                        <input type="hidden" name="f" value="<?php echo $_REQUEST['f']; ?>" />
                        <input type="hidden" name="t" value="<?php echo $_REQUEST['t']; ?>" />
                        <input type="hidden" name="p" value="<?php echo $_REQUEST['p']; ?>" />
        			</form>
                        </td>
                    </tr> 
                    <tr>
                    	<td align="center" style="border:none">
                        <br />
                    	<form action="" method="get">
                    	<input value="Delete Post" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> 
                    	<input type="hidden" name="delete_post" value="yes" />
                        <input type="hidden" name="f" value="<?php echo $_REQUEST['f']; ?>" />
                        <input type="hidden" name="t" value="<?php echo $_REQUEST['t']; ?>" />
                        <input type="hidden" name="p" value="<?php echo $_REQUEST['p']; ?>" />
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
