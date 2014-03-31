<?
include "header.php";?>
<table align="center" width="80%" id="Register">
	<tr>
	<td>
	User Name and Password Recovery
	</td>
	</tr>
    <tr>       
        <td style="border:none">
        <form action="" method="get">
        <table align="center" width="70%" style="border: none">
        	<tr>
            	<td style="border:none" align="center">
    			<?php

				if(isset($_SESSION["loggedin"]))
				{
				?>
	             	<font size="-1" color="#FF0000">You are already logged into the IASIP Forums.</font>
    	            <br />
				<?php
					exit();
				}
				if(isset($_REQUEST["recover_user_data"]))
				{
					$correct_email = "true";
					
					if($_REQUEST["email"] != $_REQUEST["confirm_email"] ||  empty($_REQUEST["email"]))
					{				
						$correct_email = "false";
				?>
                   	 	<font size="-1" color="#FF0000">Your email and confirm email entries did not match or they are blank.</font>
                    	<br />
                <?php
					}					
				
					if($correct_email=='true')
					{
						$dbconnection = mysql_connect("abtingramiancom.ipagemysql.com","gramian","L@kers13");

						mysql_select_db("agdatabase", $dbconnection); 						

						$thesql = "SELECT userName,userPassword,userEmail FROM users 
										WHERE userEmail = '" . addslashes($_REQUEST["email"]) . "'";
		
						$results = mysql_query($thesql);						
						
						if(mysql_num_rows($results)>0)
						{
							while ($currentrow = mysql_fetch_array($results))
							{
	   							mail($currentrow["userEmail"],"IASIP Forums Account Information","User Name: " 
												 . $currentrow["userName"] . "\nPassword: " . $currentrow["userPassword"],
												 "From: IASIP Forums");
							
								echo "<center>A message with your account information was sent to the supplied email address!</center>";
								exit();
							}
						}
						else
						{
				?>
                			<font size="-1" color="#FF0000">The email you supplied does not match any entries in the database.</font>
                    		<br />
                <?php
						}
					}
				}
				?>                
                	<font size="-1">
                	Please enter your email address below in order to recover your account information.
                    </font>
                	<br />
					<br />
                </td>
            </tr>
            <tr>
                <td style="border:none">
                <table align="center" style="border: none">
                	<tr>
                		<td colspan="2" style="border:none">
                		<br />
                		<font size="-1">Please enter your email address.</font>
               			<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                		Email Address:
                		<br />
               			<input name="email" type="text" class="text">
                        </td>
                        <td style="border:none">
                        Confirm Email Address:
                		<br />
               			<input name="confirm_email" type="text" class="text">
                		</td>
                	</tr>
                	<tr>
                		<td align="center" colspan="2" style="border:none">
                        <br />
						<br />
                		<input value="Recover Account Information" class="btn" onMouseOver="this.className='btn btnhov'" onMouseOut="this.className='btn'" type="submit"> <input value="Reset Fields" class="btn" onMouseOver="this.className='btn btnhov'" onMouseOut="this.className='btn'" type="Reset">
                        </td>
                    </tr>                                       
                </table>
                </td>
            </tr>           
        </table>
        <input type="hidden" name="recover_user_data" value="yes" />
        </form>
        </td>
    </tr>
</table>
</center>

<noscript>
</body>
</html>
