<?php 
include "header.php";

$dbconnection = mysql_connect("abtingramiancom.ipagemysql.com","gramian","L@kers13");
if (!$dbconnection)
	{
	die('problem connecting to the db');	
	}
mysql_select_db("agdatabase", $dbconnection); 
?>
<table align="center" width="80%" id="Register">
	<tr>
	<td colspan="5">
    <?php
    if(isset($_REQUEST["search"])&&!empty($_REQUEST["keywordsearch"]))
		echo "Search keyword(s): " . $_REQUEST["keywordsearch"];
	else
		echo "Search Forums";
	?>
	</td>
	</tr>
	        <?php
            if(isset($_REQUEST["search"]))
			{
				if(!empty($_REQUEST["keywordsearch"]))
				{
					$postSql = "SELECT topicID FROM posts 
									WHERE postName LIKE '%" . $_REQUEST["keywordsearch"] . "%'
								    OR postMessage LIKE '%" . $_REQUEST["keywordsearch"] . "%'
									OR userName LIKE '%" . $_REQUEST["keywordsearch"] . "%'
									ORDER BY topicID";
					$postResults = mysql_query($postSql);
					
					if(mysql_num_rows($postResults)>0)
					{
						$topicSql = "SELECT * FROM topics WHERE"; 
				
						if(isset($_REQUEST["forum"]))
						{
							if($_REQUEST["forum"] != "ALL")
							{
								$topicSql .= " forumID= " . $_REQUEST["forum"];
							}
						}
						$count = 1;
						while($currentrow = mysql_fetch_array($postResults))
						{
							if(isset($_REQUEST["forum"]) && $_REQUEST["forum"] != "ALL" && $count==1)
								$topicSql .= " AND";
							if($count ==1)
								$topicSql .= " (";
							else
								$topicSql .= " OR ";
							$topicSql .= "topicID = " . $currentrow["topicID"];
							$count++;
						}
						$topicSql .= ")";
						if(!isset($_REQUEST["sort"]))
							$_REQUEST["sort"] = 'topicid';
						if($_REQUEST["sort"] == 'topicid')
						{
							$topicSql .= " ORDER BY topicID";
						}
						else if($_REQUEST["sort"] == 'topicname')
						{
							$topicSql .= " ORDER BY topicName";
						}
						else if($_REQUEST["sort"] == 'lastpost')
						{
							$topicSql .= " ORDER BY lastPost DESC";
						}
						else if($_REQUEST["sort"] == 'replies')
						{
							$topicSql .= " ORDER BY numReplies DESC";
						}
						else if($_REQUEST["sort"] == 'views')
						{
							$topicSql .= " ORDER BY numViews DESC";
						}
						else if($_REQUEST["sort"] == 'forum')
						{
							$topicSql .= " ORDER BY forumID";
						}
						$topicResults = mysql_query($topicSql);
						$results = $topicResults;
						
						if($results)
						{
							if(empty($_REQUEST["start"]))
							{ $start=1; }
							else
							{ $start = $_REQUEST["start"]; }
							$resultsPerPage = 5;	
							$end = $start + $resultsPerPage-1;

							if (mysql_num_rows($results) < $end)
							{ $end = mysql_num_rows($results); }
		
							$counter = $start;
	
							include "next_previous.php"; ?>
        	               	<tr>
    						<td  colspan="5" style="border:none; padding:5px;" align="left">
					        <form action="search.php" method="get">
							<input value="New Search" class="btn" onmouseover="this.className='btn btnhov'" onmouseout="this.className='btn'" type="submit">
							</form>
				    	    </td>
						    </tr>	
							<tr>
							<td width="50%" align="left" style="padding:5px;">
							<a href="search.php?sort=topicname&keywordsearch=<?php echo $_REQUEST["keywordsearch"]?>&forum=<?php echo $_REQUEST["forum"]?>&search=<?php $_REQUEST["search"]?>"><u>Topic</u></a>
							</td>
							<td width="20%" align="center" style="padding:5px;">
							<a href="search.php?sort=lastpost&keywordsearch=<?php echo $_REQUEST["keywordsearch"]?>&forum=<?php echo $_REQUEST["forum"]?>&search=<?php $_REQUEST["search"]?>"><u>Last Post</u></a>
							</td>
							<td width="5%" align="center" style="padding:5px;">
							<a href="search.php?sort=replies&keywordsearch=<?php echo $_REQUEST["keywordsearch"]?>&forum=<?php echo $_REQUEST["forum"]?>&search=<?php $_REQUEST["search"]?>"><u>Replies</u></a>
							</td>
						    <td width="5%" align="center" style="padding:5px;">
							<a href="search.php?sort=views&keywordsearch=<?php echo $_REQUEST["keywordsearch"]?>&forum=<?php echo $_REQUEST["forum"]?>&search=<?php $_REQUEST["search"]?>"><u>Views</u></a>
							</td>
                	        <td width="20%" align="center" style="padding:5px;">
							<a href="search.php?sort=forum&keywordsearch=<?php echo $_REQUEST["keywordsearch"]?>&forum=<?php echo $_REQUEST["forum"]?>&search=<?php $_REQUEST["search"]?>"><u>Forum</u></a>
							</td>
							</tr>
			<?php
							mysql_data_seek($results,$start-1);

							while ($currentrow = mysql_fetch_array($results))
							{
								echo "<tr> ";
								echo "<td align='left' style='padding:5px;'>";
								echo "<a href='posts.php?f=" . $currentrow["forumID"] . "&t=" . $currentrow["topicID"] . "'>" . $currentrow["topicName"] . "</a>";
								echo "<br /><font size='-1' color=#666>By: " . $currentrow["userName"] . "</font>";
								if($membertype=="Administrator")
								{
		        					echo "<form action='edit_topic.php' method='get'>";
									echo "<input value='Edit/Delete Topic' class=\"btn\" onmouseover=\"this.className='btn btnhov'\" onmouseout=\"this.className='btn'\" type=\"submit\">";
        							echo "<input value=" . $currentrow["topicID"] . " type='hidden' name='topicID' />";
									echo "</form>";
								}
								echo "</td>";
								echo "<td align='center' style='padding:5px;'>";
								echo $currentrow["lastPost"];
								echo "</td>";
								echo "<td align='center' style='padding:5px;'>";
								echo $currentrow["numReplies"];
								echo "</td>";
								echo "<td align='center' style='padding:5px;'>";
								echo $currentrow["numViews"];
								echo "</td>";
								echo "<td align='center' style='padding:5px;'>";
								$forumSql = "SELECT forumName FROM forums WHERE forumID =" . $currentrow["forumID"];
								$forumResults = mysql_query($forumSql);
								$forumrow = mysql_fetch_array($forumResults);
								echo "<a href='topics.php?f=" . $currentrow["forumID"] . "'>" . $forumrow["forumName"] . "</a>";
								echo "</td>";
								echo "</tr>";

								if($counter==$end)
								{ break; }
		
								$counter ++;

							}
							include "next_previous.php"; 
			?>
						</table>
            <?php
						exit();
						}
						else
						{
			?>
        					<tr>       
        					<td style="border:none">
        					<table align="center" width="70%" style="border: none">
            				<tr>
                        		<td align="center" style="border: none">
	            				<font size="-1" color="#FF0000">Your search did not return any results.</font>
    	           				<br />
                            	</td>
                        	</tr>
            <?php
						}
					}
					else
					{
			?>
        				<tr>       
        				<td style="border:none">
        				<table align="center" width="70%" style="border: none">
            			<tr>
                        	<td align="center" style="border: none">
	            			<font size="-1" color="#FF0000">Your search did not return any results.</font>
    	           			<br />
                            </td>
                        </tr>
            <?php
					}					
				}
				else
				{
			?>
           			<tr>       
        			<td style="border:none">
        			<table align="center" width="70%" style="border: none">
            		<tr>
                       	<td align="center" style="border: none">
            			<font size="-1" color="#FF0000">You did not enter any keywords.</font>
               			<br />
                        </td>
                   </tr>
            <?php
				}
			}
			?>
            <tr>
                <td style="border:none">
                <form action="" method="get">
                <table align="center" style="border: none">
                	<tr>
                		<td colspan="2" style="border:none">
                		<font size="-1">You may search the IASIP forums using the search criteria displayed below.</font>
               			<br />
                        <br />
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border:none" align="center">
                		Search by Keyword(s):
                		<br />
               			<input name="keywordsearch" type="text" class="text">
                        </td>
                	</tr>
                    <tr>
                    	<td colspan="2" style="border:none" align="center">
                        <br />
                        Search in Forum(s)
                        <select name="forum">
							<option value='ALL'>ALL</option>
							<?php
							$forumsql = "SELECT forumID,forumName FROM forums";
							$forumresults = mysql_query($forumsql);
							while ($currentrow = mysql_fetch_array($forumresults))
							{
								echo "<option value='" . $currentrow["forumID"] . "'>" .  $currentrow["forumName"]  . "</option>";
							}
							?>

						</select>
                        </td>
                    </tr>
                	<tr>
                		<td align="center" colspan="2" style="border:none">
						<br />
                		<input value="Keyword Search" class="btn" onMouseOver="this.className='btn btnhov'" onMouseOut="this.className='btn'" type="submit"> <input value="Reset Fields" class="btn" onMouseOver="this.className='btn btnhov'" onMouseOut="this.className='btn'" type="Reset">
                        <input type="hidden" name="search" value="yes" />
        				</form>
                        </td>
                    </tr>
                    <tr>
                    	<form action="members.php" method="get">
                        <td colspan="2" style="border:none" align="center">
                		<br />
						<br />
                        Search for Member(s):
                		<br />
               			<input name="membersearch" type="text" class="text">
                        </td>
                	</tr>
                	<tr>
                		<td align="center" colspan="2" style="border:none">
                        <br />
                		<input value="Member Search" class="btn" onMouseOver="this.className='btn btnhov'" onMouseOut="this.className='btn'" type="submit"> <input value="Reset Fields" class="btn" onMouseOver="this.className='btn btnhov'" onMouseOut="this.className='btn'" type="Reset">
                        <input type="hidden" name="search" value="yes" />
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
