<?
include "header.php";

if(!isset($_SESSION["loggedin"]) || $membertype != "Administrator")
{
?>
	<script language="javascript">	
		window.location = "forums.php";
	</script>
<?php 
exit();
}
?>
<table align="center" width="80%" id="Register">
	<tr>
	<td align="left">
	Edit/Delete Forum
	</td>
	</tr>
    <tr>       
        <td style="border:none">
        <table align="center" width="70%" style="border: none">
        	<tr>
            	<td style="border:none" align="center">
    			<?php
				if(isset($_REQUEST["delete_forum"]))
				{
					$thesql = "DELETE FROM forums 
									WHERE forumID = " . $_REQUEST["f"];	
					mysql_query($thesql);					
					echo "<center>The forum was successfully deleted!</center>";
					exit();
				}
				else if(isset($_REQUEST["edit_forum"]))
				{
					if(empty($_REQUEST["forumname"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a name for the forum.</font>
    	                <br />
                <?php
					}
					
					if(empty($_REQUEST["tagline"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a tagline for the forum.</font>
    	                <br />
                <?php
					}			
				
					if(!empty($_REQUEST["forumname"]) && !empty($_REQUEST["tagline"]))
					{
						$thesql = "UPDATE forums 
									SET forumName = '" . addslashes($_REQUEST["forumname"]) . "', 
										forumTagline = '" . nl2br(addslashes($_REQUEST["tagline"])) . "'
									WHERE forumID = " . $_REQUEST["f"];	
						mysql_query($thesql);					
						echo "<center>The forum was successfully updated!</center>";
						echo "<br />";
					}
				}
				?>                
                </td>
            </tr>
            <tr>
                <td style="border:none">
                <?php
				$thesql = "SELECT * FROM forums WHERE forumID = " . $_REQUEST["f"];
				$results = mysql_query($thesql);
				$currentrow = mysql_fetch_array($results); 
				?>
                <table align="center" style="border: none">            
                    <form action="" method="get">
                    <tr>
                        <td style="border:none">
                		Forum Name:
                		<br />
                		<input size="60"  name="forumname" type="text" class="text" value="<?php echo $currentrow["forumName"]; ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                        Tagline:
                		<br />
                        <textarea name = "tagline" rows="5" cols="80" wrap="soft"><?php echo $currentrow["forumTagline"]; ?></textarea>
                        </td>
                	</tr>                    
                	<tr>
                		<td align="center" style="border:none">
                        <br />
                		<input value="Edit Forum" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> 
                        <input type="hidden" name="edit_forum" value="yes" />
                        <input type="hidden" name="f" value="<?php echo $_REQUEST['f']; ?>" />
        			</form>
                        </td>
                    </tr> 
                    <tr>
                    	<td align="center" style="border:none">
                        <br />
                    	<form action="" method="get">
                    	<input value="Delete Forum" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> 
                    	<input type="hidden" name="delete_forum" value="yes" />
                        <input type="hidden" name="f" value="<?php echo $_REQUEST['f']; ?>" />
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
