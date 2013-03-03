<?php
    $targetpage = ""; 	
    $limit = 1;	
                                
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
    $result = $db->getProjectsInfoWithStartAndLimit($start,$limit);
	//echo "I am here.";
    //print_r($result);
	//while ($project = mysql_fetch_array($result)){
		//echo $project['project_title'];
	//}
	
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
    				<th>ID</th> 
    				<th>Project Title</th> 
    				<th>Project Description </th> 
                    <th>User ID</th>
                    <th>Set Date </th>
                  </tr> 
			</thead> 
			<tbody> 
                  <?php
				  	while($row = mysql_fetch_row($result))
  					{
						$id = $row[0];
						$title = $row[1];
						$description = $row[2];
						$userid = $row[3];
						$setdate = $row[4];
						
				  ?>      
                  <tr>    					
    				<td><?php echo $id; ?>  </td> 
    				<td><?php echo $title; ?></td> 
    				<td><?php echo $description; ?></td> 
                    <td><?php echo $userid; ?></td> 
                    <td><?php echo $setdate; ?>></td> 
                    
    				
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
