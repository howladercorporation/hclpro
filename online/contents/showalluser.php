<?php
    $targetpage = ""; 	
    $limit = 5;	
                                
    $total_pages = $db->totalRowInUsers();
    //$total_pages = 0;
	
    $stages = 3;    
    if(isset($_GET['p'])){
        $page = mysql_escape_string($_GET['p']);
        $start = ($page - 1) * $limit; 
    }else{
        $start = 0;	
    }	
	
    // Get page data
    $result = $db->getUsersInfoWithStartAndLimit($start,$limit);
    //print_r($result);
	
    // Initial page num setup
    if ($page == 0){$page = 1;}
    $prev = $page - 1;	
    $next = $page + 1;							
    $lastpage = ceil($total_pages/$limit);		
    $LastPagem1 = $lastpage - 1;
?>

<section id="main" class="column">	
		
    <article class="module width_full">
	<header><h3>All Users</h3></header>
        <div class="module_content" style="padding: 0 !important; margin: 0 !important;">
                    <table class="tablesorter" cellspacing="0" style="width: 100% !important;"> 
			<thead> 
                  <tr>    				
    				<th>Username</th> 
    				<th>First Name</th> 
    				<th>Last Name</th> 
                    <th>Email</th>
                    <th>User Type</th>
                    <th>Active</th>
    				<th>Actions</th> 
                  </tr> 
			</thead> 
			<tbody> 
                  <?php
				  	while($row = mysql_fetch_row($result))
  					{
						$username = $row[1];
						$fname = $row[4];
						$lname = $row[5];
						$email = $row[6];
						$usertype = $row[7];
						$active = $row[8];
				  ?>      
                  <tr>    					
    				<td><?php echo $username; ?>  </td> 
    				<td><?php echo $fname; ?></td> 
    				<td><?php echo $lname; ?></td> 
                    <td><?php echo $email; ?></td> 
                    <td><?php 		
							echo $usertype=='1'?"Admin":"User";
						?></td> 
                    <td><?php echo $active=='Y'?"Yes":"No"; ?></td> 
                    
    				<td><input type="image" src="images/icn_edit.png" title="Edit"><input type="image" src="images/icn_trash.png" title="Trash"></td> 
                  </tr> 
                  <?php
				  	}
				  ?>       
			</tbody> 
                    </table>
		</div>
                <footer>
			
                            <?php	
                                $paginate = '';
                                if($lastpage > 1)
                                {
                                    $paginate .= "<div class='paginate'>";
                                    // Previous
                                    if ($page > 1){
                                        $paginate.= "<a href='$targetpage?p=$prev&page=showallusers'>previous</a>";
                                    }else{
                                        $paginate.= "<span class='disabled'>previous</span>";	
                                    }		
                                    // Pages	
                                    if ($lastpage < 7 + ($stages * 2))	// Not enough pages to breaking it up
                                    {	
                                        for ($counter = 1; $counter <= $lastpage; $counter++)
                                        {
                                            if ($counter == $page){
                                                    $paginate.= "<span class='current'>$counter</span>";
                                            }else{
                                                    $paginate.= "<a href='$targetpage?p=$counter&page=showallusers'>$counter</a>";                               
                                            }					
                                        }
                                    }
                                    elseif($lastpage > 5 + ($stages * 2))	// Enough pages to hide a few?
                                    {
                                        // Beginning only hide later pages
                                        if($page < 1 + ($stages * 2))		
                                        {
                                            for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)
                                            {
                                                if ($counter == $page){
                                                    $paginate.= "<span class='current'>$counter</span>";
                                                }else{
                                                    $paginate.= "<a href='$targetpage?p=$counter&page=showallusers'>$counter</a>";                                                    
                                                }					
                                            }
                                            $paginate.= "...";
                                            $paginate.= "<a href='$targetpage?p=$LastPagem1&page=showallusers'>$LastPagem1</a>";
                                            $paginate.= "<a href='$targetpage?p=$lastpage&page=showallusers'>$lastpage</a>";		
                                        }
                                        // Middle hide some front and some back
                                        elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))
                                        {
                                            $paginate.= "<a href='$targetpage?p=1&page=showallusers'>1</a>";
                                            $paginate.= "<a href='$targetpage?p=2&page=showallusers'>2</a>";
                                            $paginate.= "...";
                                            for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)
                                            {
                                                if ($counter == $page){
                                                    $paginate.= "<span class='current'>$counter</span>";
                                                }else{
                                                    $paginate.= "<a href='$targetpage?p=$counter&page=showallusers'>$counter</a>";                                                    
                                                }					
                                            }
                                            $paginate.= "...";
                                            $paginate.= "<a href='$targetpage?p=$LastPagem1&page=showallusers'>$LastPagem1</a>";
                                            $paginate.= "<a href='$targetpage?p=$lastpage&page=showallusers'>$lastpage</a>";		
                                        }
                                        // End only hide early pages
                                        else
                                        {
                                            $paginate.= "<a href='$targetpage?p=1&page=showallusers'>1</a>";
                                            $paginate.= "<a href='$targetpage?p=2&page=showallusers'>2</a>";
                                            $paginate.= "...";
                                            for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)
                                            {
                                                if ($counter == $page){
                                                    $paginate.= "<span class='current'>$counter</span>";
                                                }else{
                                                    $paginate.= "<a href='$targetpage?p=$counter&page=showallusers'>$counter</a>";                                                    
                                                }					
                                            }
                                        }
                                    }
					
                                    // Next
                                    if ($page < $counter - 1){ 
                                        $paginate.= "<a href='$targetpage?p=$next&page=showallusers'>next</a>";
                                    }else{
                                        $paginate.= "<span class='disabled'>next</span>";
                                    }
			
                                    $paginate.= "</div>";		
	
	
                                }
                                //echo '<div>'.$total_pages.' Results</div>';
                                // pagination
                                echo $paginate;
                            ?>
			
		</footer>
    </article><!-- end of post new article -->
</section>
