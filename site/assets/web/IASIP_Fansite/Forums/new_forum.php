<?php 
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
	Create New Forum
	</td>
	</tr>
    <tr>       
        <td style="border:none">
        <table align="center" width="70%" style="border: none">
        	<tr>
            	<td style="border:none" align="center">
    			<?php		
				if(isset($_REQUEST["complete_new_forum"]))
				{
					if(empty($_REQUEST["forumname"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a name for your forum.</font>
    	                <br />
                <?php
					}
					
					if(empty($_REQUEST["tagline"]))
					{
				?>
	                    <font size="-1" color="#FF0000">Please enter a tagline for your new forum.</font>
    	                <br />
                <?php
					}			
				
					if(!empty($_REQUEST["forumname"]) && !empty($_REQUEST["tagline"]))
					{
						$thesql = "INSERT INTO forums
		   							(forumName, forumTagline)
				   					VALUES
							   		('" . addslashes($_REQUEST["forumname"]) . "', '" 
									   . nl2br(addslashes($_REQUEST["tagline"])) . "')";
		   
						mysql_query($thesql);					
						echo "<center>Your new forum was successfully created!</center>";
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
                		Forum Name:
                		<br />
                		<input size="60"  name="forumname" type="text" class="text">
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                        Tagline:
                		<br />
                        <textarea name = "tagline" rows="5" cols="80" wrap="soft"></textarea>
                        </td>
                	</tr>                    
                	<tr>
                		<td align="center" style="border:none">
                        <br />
                		<input value="Submit New Forum" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> <input value="Reset Fields" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="Reset">
                        </td>
                    </tr> 
                    <input type="hidden" name="complete_new_forum" value="yes" />
        			</form>                                     
                </table>
                </td>
            </tr>                    
        </table>

        </td>
    </tr>
</table>
</center>
