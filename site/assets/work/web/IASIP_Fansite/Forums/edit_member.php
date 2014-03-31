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
<table align="center" width="80%">
	<tr>
	<td>
	Edit/Delete Member
	</td>
	</tr>
    <tr>       
        <td style="border:none">
        <table align="center" width="70%" style="border: none">
        	<tr>
            	<td style="border:none;padding:20px" align="center">
    			<?php
				if(isset($_REQUEST["delete_member"]))
				{
					$thesql = "DELETE FROM users 
									WHERE userID = " . $_REQUEST["u"];	
					mysql_query($thesql);					
					echo "<center>The member was successfully deleted!</center>";
					exit();
				}
				if(isset($_REQUEST["upload_picture"]))
				{	
					$validfiletype = false;
					$validfilesize = true;
					$nouploaderrors = true;
					
					if (($_FILES["thefile"]["type"] == "image/gif")
					|| ($_FILES["thefile"]["type"] == "image/jpeg")
					|| ($_FILES["thefile"]["type"] == "image/pjpeg")
					|| ($_FILES["thefile"]["type"] == "image/png")
					|| ($_FILES["thefile"]["type"] == "image/bmp"))
  					{
						$validfiletype = true;
  					}
					if($_FILES["thefile"]["size"] > 1000000)
  					{
						$validfilesize = false;
  					}
					if($_FILES["thefile"]["error"] > 0)
    				{
						$nouploaderrors = false;
					}
					if($validfiletype && $validfilesize && $nouploaderrors)
					{
						$thesql = "SELECT userName FROM users WHERE userID = '" . addslashes($_REQUEST["u"]) . "'";
						$results = mysql_query($thesql);											
						$currentrow = mysql_fetch_array($results);
						$username = addslashes($currentrow["userName"]);
						
						$filename = $_FILES['thefile']['name'];
						$ext = substr(strrchr($filename, '.'), 1);
						$newfilename = $username . "." . $ext;
						$file_location = "userPics\\" . $newfilename;
					
						move_uploaded_file($_FILES["thefile"]["tmp_name"], $file_location);
					
						$updatesql = "UPDATE users SET userPic = '" . addslashes($newfilename) .
										"' WHERE userID = '" . addslashes($_REQUEST["u"]) . "'";	
						mysql_query($updatesql);	
					
						echo "<center>The picture was successfully uploaded!</center><br /><br />";
						echo "<br />";
					}
					else
					{
				?>
						 <font size="-1" color="#FF0000">
                         The file could not be uploaded. 
                         <br />
					 	 Please ensure that the chosen file was the proper size and type.</font>
    	             	 <br />
                <?php
					}
				}
				else if(isset($_REQUEST["delete_picture"]))
				{				
					$thesql = "SELECT userPic FROM users WHERE userID = '" . addslashes($_REQUEST["u"]) . "'";
		
					$results = mysql_query($thesql);						
						
					$currentrow = mysql_fetch_array($results);
										
					$deleteFile = "userPics/" . $currentrow["userPic"];
					unlink($deleteFile);

					
					$updatesql = "UPDATE users SET userPic = '' 
									WHERE userID = '" . addslashes($_REQUEST["u"]) . "'";	
					mysql_query($updatesql);	
					echo "<center>The picture was successfully deleted!</center>";
					echo "<br />";
				}				
				else if(isset($_REQUEST["change_settings"]))
				{
					$correct_password = true;
					$correct_email = true;
					$correct_username = true;	
					$unique_username = true;
					
					if($_REQUEST["new_username"] != $_REQUEST["confirm_new_username"])
					{
						$correct_username = false;
				?>
	                    <font size="-1" color="#FF0000">Your new user name and confirm user name entries did not match or they are blank.</font>
    	                <br />
                <?php
					}

					if($_REQUEST["new_password"] != $_REQUEST["confirm_new_password"])
					{
						$correct_password = false;
				?>
	                    <font size="-1" color="#FF0000">Your new password and confirm password entries did not match or they are blank.</font>
    	                <br />
                <?php
					}
					if($_REQUEST["new_email"] != $_REQUEST["confirm_new_email"])
					{				
						$correct_email = false;
				?>
                   	 	<font size="-1" color="#FF0000">Your new email and confirm email entries did not match or they are blank.</font>
                    	<br />
                <?php
					}				
				
					if($correct_email == true && !empty($_REQUEST["new_email"]))
					{
						include "email_validation.php";
						if(!checkEmail(trim($_REQUEST["new_email"])))
						{
							$correct_email = false;
				?>
                			<font size="-1" color="#FF0000">The new email address you supplied is invalid.</font>
                    		<br />
                <?php
						}
					}				
				
					if($correct_password==true && $correct_email==true && $correct_username==true)
					{					
						$thesql = "SELECT userName,userID FROM users 
										WHERE userName = '" . addslashes($_REQUEST["new_username"]) . "'";
		
						$results = mysql_query($thesql);						
						
						if( !empty($_REQUEST["new_username"]))
							while($currentrow = mysql_fetch_array($results))
							{
								if($currentrow["userName"] == $_REQUEST["new_username"] && $currentrow["userID"]!=$_REQUEST["u"])
									$unique_username = false;
							}
						if($unique_username == false)
						{
				?>
                		<font size="-1" color="#FF0000">The user name you entered already exists.</font>
                    	<br />
                <?php
						}

						if($unique_username == true)
						{						
							$updatesql = "UPDATE users SET";
							if(!empty($_REQUEST["new_username"]))
								$updatesql .= " userName = '" . addslashes($_REQUEST["new_username"])	. "'";
							if(!empty($_REQUEST["new_password"]))	
							{
								if(!empty($_REQUEST["new_username"]))
									$updatesql .= ",";
								$updatesql .= " userPassword = '" . addslashes($_REQUEST["new_password"])	. "'";
							}
							if(!empty($_REQUEST["new_email"]))
							{
								if(!empty($_REQUEST["new_username"]) || !empty($_REQUEST["new_password"]))
									$updatesql .= ",";
								$updatesql .= " userEmail = '" . addslashes($_REQUEST["new_email"])	. "'";
							}
							if(!empty($_REQUEST["new_username"]) || !empty($_REQUEST["new_pasword"]) || !empty($_REQUEST["new_email"]))
								$updatesql .= ",";
							$updatesql .= " userSignature = '" . nl2br(addslashes($_REQUEST["signature"])) . "'";
							
							$updatesql .= " WHERE userID = '" . addslashes($_REQUEST["u"]) . "'";	
							
							if(!empty($_REQUEST["new_username"]) || !empty($_REQUEST["new_pasword"]) || !empty($_REQUEST["new_email"]) || !empty($_REQUEST["signature"]))
							{
								mysql_query($updatesql);

								echo "<center>The changes to the user's account settings were successfully completed!</center>";
								echo "<br />";
							}
							else
							{
								echo "<center>You did not enter any values for the account settings.</center>";
								echo "<br />";
							}
						}
					}
				}
				?>         
                </td>
            </tr>
            <tr>
                <td style="border:none">
                <table align="center" style="border: none">            
                	<tr>
                		<td colspan="2" style="border:none">
                		<font size="-1">Change the user name for the account. Note that user names are case-sensitive.</font>
               			<br />
                        </td>
                    </tr>
                    <?php
						$thesql = "SELECT * FROM users WHERE userID = " . $_REQUEST["u"];
						$results = mysql_query($thesql);						
						$currentrow = mysql_fetch_array($results);
					?>
                    <form action="" method="get">
                    <tr>
                        <td style="border:none">
                		Change User Name:
                		<br />
                		<input name="new_username" type="text" class="text" value="<?php echo $currentrow["userName"]; ?>">
                        </td>
                        <td style="border:none">
                		Confirm Change User Name:
                		<br />
                		<input name="confirm_new_username" type="text" class="text" value="<?php echo $currentrow["userName"]; ?>">
                        </td>                        
                	</tr>                
                	<tr>
                		<td colspan="2" style="border:none">
                		<br />
                		<font size="-1">Change the password for the user account. Note that passwords are case-sensitive.</font>
               			<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                		Change Password:
                		<br />
               			<input name="new_password" type="text" class="text" value="<?php echo $currentrow["userPassword"]; ?>">
                        </td>
                        <td style="border:none">
                        Confirm Change Password:
                		<br />
               			<input name="confirm_new_password" type="text" class="text" value="<?php echo $currentrow["userPassword"]; ?>">
                		</td>
                	</tr>
                	<tr>
                		<td colspan="2" style="border:none">
                		<br />
                		<font size="-1">Change the email address for the user.</font>
               			<br />
                        </td>
                    </tr>
                    <tr>
                        <td style="border:none">
                		Change Email Address:
                		<br />
               			<input name="new_email" type="text" class="text" value="<?php echo $currentrow["userEmail"]; ?>">
                        </td>
                        <td style="border:none">
                        Confirm Change Email Address:
                		<br />
               			<input name="confirm_new_email" type="text" class="text" value="<?php echo $currentrow["userEmail"]; ?>">
                		</td>
                	</tr>
                	<tr>
                		<td colspan="2" style="border:none">
                		<br />
                		<font size="-1">Edit the user's personal signature in the box below. (optional)</font>
               			<br />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none">
                		Change User Signature:
                		<br />
                        <?php						
						if(!empty($currentrow["userSignature"]))
						{
						?>
               			<textarea name = "signature" rows="20" cols="80" wrap="soft"><?php echo $currentrow["userSignature"]; ?></textarea>
                        <?php
						}
						else
						{
						?>
                        <textarea name = "signature" rows="20" cols="80" wrap="soft"></textarea>
                        <?php
						}
						?>
                        </td>
                	</tr>                    
                	<tr>
                		<td align="center" colspan="2" style="border:none">
                        <br />
						<br />
                		<input value="Change Settings" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> <input value="Reset Fields" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="Reset">
                        </td>
                    </tr> 
                    <input type="hidden" name="change_settings" value="yes" />
                    <input type="hidden" name="u" value="<?php echo $_REQUEST["u"]; ?>" />
        			</form>
                	<tr>
                		<td colspan="2" style="border:none;padding-top:10px;padding-bottom:10px;">
                        <?php						
						if(!empty($currentrow["userPic"]))
						{
						?>
                       		<br />
                            <br />
                            <center>
                        <?php
                            echo "<img width='300px' src='userPics/" . addslashes($currentrow["userPic"]) . "' />";
						?>
                        	</center>
							<br />
                            <br />
                			<font size="-1">The user's current profile picture is displayed above.
                            <br />
							To delete the user's profile picture click on the following button. 
                            <br />
                        	<form action="" method="get">
								<input type="submit" value="Delete Picture" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" />
                        		<input type="hidden" name="delete_picture" value="yes" />
                                <input type="hidden" name="u" value="<?php echo $_REQUEST["u"]; ?>" />
                        		</form> 
                                <br />
								<br /> 
	                            You may upload a new profile picture for the account by browsing for the file below.
                                <br />
                                Maximum file size: 1000kb
                                <br />
								Acceptable file formats: .jpeg, .png, .bmp, and .gif 
                                </font>
               					<br />
						<?php
						}
						
						else
						{
						?>
                		<br />
                		<font size="-1">You may upload a profile picture for the account by browsing for the file below.
               			<br />
                        Maximum file size: 1000kb
                        <br />
						Acceptable file formats: .jpeg, .png, .bmp, and .gif
                        </font>
                        <?php
						}
						?>
                        </td>
                    </tr>
                    <tr>
                    <form action="" method="post" enctype="multipart/form-data">
                        <td style="border:none;padding-bottom:20px">
						<input type="file" name="thefile"  class="" />
						<input type="submit" value="Upload Picture" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" />
                        </td>
                        <input type="hidden" name="upload_picture" value="yes" />
                        <input type="hidden" name="u" value="<?php echo $_REQUEST["u"]; ?>" />
                        </form>                        
                    </tr> 
                    <tr>
                    	<td colspan='2' align="center" style="border:none">
                        <br />
                    	<form action="" method="get">
                    	<input value="Delete Member" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit"> 
                    	<input type="hidden" name="delete_member" value="yes" />
                        <input type="hidden" name="u" value="<?php echo $_REQUEST['u']; ?>" />
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

<noscript>
</body>
</html>
