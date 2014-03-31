<?php include "header.php";?>
<table align="center" width="80%" id="Register">
	<tr>
	<td>
	Register at IASIP Forums
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
	             	<font size="-1" color="#FF0000">You are already a registered member of the IASIP Forums.</font>
    	            <br />
				<?php
					exit();
				}
				if(isset($_REQUEST["complete_registration"]))
				{
					$correct_password = true;
					$correct_email = true;
					$correct_username = true;	
					$unique_username = true;
					if($_REQUEST["registration_password"] != $_REQUEST["confirm_registration_password"] || empty($_REQUEST["registration_password"]))
					{
						$correct_password = false;
				?>
	                    <font size="-1" color="#FF0000">Your password and confirm password entries did not match or they are blank.</font>
    	                <br />
                <?php
					}
					if($_REQUEST["email"] != $_REQUEST["confirm_email"] ||  empty($_REQUEST["email"]))
					{				
						$correct_email = false;
				?>
                   	 	<font size="-1" color="#FF0000">Your email and confirm email entries did not match or they are blank.</font>
                    	<br />
                <?php
					}
					
					if($correct_email == true)
					{
						include "email_validation.php";
						if(!checkEmail(trim($_REQUEST["email"])))
						{
							$correct_email = false;
				?>
                			<font size="-1" color="#FF0000">The email address you supplied is invalid.</font>
                    		<br />
                <?php
						}
					}	
					
					if(empty($_REQUEST["registration_username"]))
					{				
						$correct_username = false;
				?>
                   	 	<font size="-1" color="#FF0000">You entered a blank username.</font>
                    	<br />
                <?php
					}					
				
					if($correct_password==true && $correct_email==true && $correct_username==true)
					{
						$dbconnection = mysql_connect("localhost","root","");

						mysql_select_db("iasipdb", $dbconnection); 						

						$thesql = "SELECT userName FROM users WHERE userName = '" . addslashes($_REQUEST["registration_username"]) . "'";
		
						$results = mysql_query($thesql);						
						
						while ($currentrow = mysql_fetch_array($results))
						{
							if($currentrow["userName"] == $_REQUEST["registration_username"])
								$unique_username = false;
						}
						if($unique_username == false)
						{
							$unique_username = false;
				?>
                		<font size="-1" color="#FF0000">The user name you entered already exists.</font>
                    	<br />
                <?php
						}

						if($unique_username == true)
						{
							$thesql = "INSERT INTO users
		   							(userName, userPassword, userEmail, memberType)
				   					VALUES
							   		('" . addslashes($_REQUEST["registration_username"]) . "','"  
										. addslashes($_REQUEST["registration_password"]) . "','"
										. addslashes($_REQUEST["email"]) . "','Member')";
		   
							mysql_query($thesql);
							echo "<center>Your registration successfully completed!<br />You may now log in.</center>";
							exit();
						}
					}
				}
				?>                
                	<font size="-1">
                	In order to be able to post messages on the IASIP Forums, you must first register. <br />
					Please enter your desired user name, your email address and other required details in the form below. 
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
                		<font size="-1">Please enter a user name for your user account. Note that user names are case-sensitive.</font>
               			<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                		User Name:
                		<br />
                		<input name="registration_username" type="text" class="text">
                        </td>
                	</tr>                
                	<tr>
                		<td colspan="2" style="border:none">
                		<br />
                		<font size="-1">Please enter a password for your user account. Note that passwords are case-sensitive.</font>
               			<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                		Password:
                		<br />
               			<input name="registration_password" type="password" class="text">
                        </td>
                        <td style="border:none">
                        Confirm Password:
                		<br />
               			<input name="confirm_registration_password" type="password" class="text">
                		</td>
                	</tr>
                	<tr>
                		<td colspan="2" style="border:none">
                		<br />
                		<font size="-1">Please enter a valid email address for yourself.</font>
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
                		<input value="Complete Registration" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> <input value="Reset Fields" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="Reset">
                        </td>
                    </tr>                                       
                </table>
                </td>
            </tr>           
        </table>
        <input type="hidden" name="complete_registration" value="yes" />
        </form>
        </td>
    </tr>
</table>
</center>

<noscript>
</body>
</html>
