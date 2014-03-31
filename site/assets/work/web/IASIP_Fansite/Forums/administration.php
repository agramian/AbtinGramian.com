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
<table align="center" width="80%" id="Administration">
	<tr>
	<td>
	Administration
	</td>
	</tr>
    <tr>       
        <td style="border:none">
        <table align="center" width="70%" style="border: none">
        	<tr>
            	<td style="border:none;padding:20px" align="center">         
                	<font size="-1">
                	As an administrator you may add a new forum and edit or delete all site content.
                    <br />
					To edit or delete a forum, topic, post, or member you must browse or search for them. 
                    </font>
                    <br />
                    <font size="-1" color="#FF0000">
                    Note: To edit the first post of a topic, you must edit the topic itself.
                    </font>
                	<br />
					<br />
                </td>
            </tr>
            <tr>
                <td style="border:none">
                
                <table align="center" style="border: none">             
                	<tr>
                		<td align="center" style="border:none">
                        <form action="new_forum.php" method="get">
                		<input value="New Forum" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit">
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