<?php
if ($_SESSION['usertype'] != '1') {
    ?>
    <section id="main" class="column">
        <h4 class="alert_error">You are not authorized person.</h4>
    </section
    <?php
    //echo '<h4 class="alert_error">An Error Message</h4>';
    exit();
}
$targetpage = "";
$limit = 1;

$total_pages = $db->totalRowInUsers();
//$total_pages = 0;


$stages = 3;
if (isset($_GET['p'])) {
    $page = mysql_escape_string($_GET['p']);
    $start = ($page - 1) * $limit;
} else {
    $start = 0;
}

// Get page data
$result = $db->getUsersInfoWithStartAndLimit($start, $limit);
//print_r($result);
// Initial page num setup
if ($page == 0) {
    $page = 1;
}
$prev = $page - 1;
$next = $page + 1;
$lastpage = ceil($total_pages / $limit);
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
                    while ($user = mysql_fetch_array($result)) {
                        ?>
                        <tr>    					
                            <td><?php echo $user['username']; ?></td> 
                            <td><?php echo $user['fname']; ?></td> 
                            <td><?php echo $user['lname']; ?></td> 
                            <td><?php echo $user['email']; ?></td> 
                            <td><?php echo $user['usertype']=='1'? "Admin":"User"; ?></td>
                            <td><?php echo $user['active']=='Y'? "Yes":"No"; ?></td>
                            <td><a href="?page=edituser&id=<?php echo $user['id']; ?>"><input type="image" src="images/icn_edit.png" title="Edit"></a></td> 
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
            if ($lastpage > 1) {
                $paginate .= "<div class='paginate'>";
                // Previous
                if ($page > 1) {
                    $paginate.= "<a href='$targetpage?p=$prev&page=showallusers'>previous</a>";
                } else {
                    $paginate.= "<span class='disabled'>previous</span>";
                }
                // Pages	
                if ($lastpage < 7 + ($stages * 2)) { // Not enough pages to breaking it up
                    for ($counter = 1; $counter <= $lastpage; $counter++) {
                        if ($counter == $page) {
                            $paginate.= "<span class='current'>$counter</span>";
                        } else {
                            $paginate.= "<a href='$targetpage?p=$counter&page=showallusers'>$counter</a>";
                        }
                    }
                } elseif ($lastpage > 5 + ($stages * 2)) { // Enough pages to hide a few?
                    // Beginning only hide later pages
                    if ($page < 1 + ($stages * 2)) {
                        for ($counter = 1; $counter < 4 + ($stages * 2); $counter++) {
                            if ($counter == $page) {
                                $paginate.= "<span class='current'>$counter</span>";
                            } else {
                                $paginate.= "<a href='$targetpage?p=$counter&page=showallusers'>$counter</a>";
                            }
                        }
                        $paginate.= "...";
                        $paginate.= "<a href='$targetpage?p=$LastPagem1&page=showallusers'>$LastPagem1</a>";
                        $paginate.= "<a href='$targetpage?p=$lastpage&page=showallusers'>$lastpage</a>";
                    }
                    // Middle hide some front and some back
                    elseif ($lastpage - ($stages * 2) > $page && $page > ($stages * 2)) {
                        $paginate.= "<a href='$targetpage?p=1&page=showallusers'>1</a>";
                        $paginate.= "<a href='$targetpage?p=2&page=showallusers'>2</a>";
                        $paginate.= "...";
                        for ($counter = $page - $stages; $counter <= $page + $stages; $counter++) {
                            if ($counter == $page) {
                                $paginate.= "<span class='current'>$counter</span>";
                            } else {
                                $paginate.= "<a href='$targetpage?p=$counter&page=showallusers'>$counter</a>";
                            }
                        }
                        $paginate.= "...";
                        $paginate.= "<a href='$targetpage?p=$LastPagem1&page=showallusers'>$LastPagem1</a>";
                        $paginate.= "<a href='$targetpage?p=$lastpage&page=showallusers'>$lastpage</a>";
                    }
                    // End only hide early pages
                    else {
                        $paginate.= "<a href='$targetpage?p=1&page=showallusers'>1</a>";
                        $paginate.= "<a href='$targetpage?p=2&page=showallusers'>2</a>";
                        $paginate.= "...";
                        for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++) {
                            if ($counter == $page) {
                                $paginate.= "<span class='current'>$counter</span>";
                            } else {
                                $paginate.= "<a href='$targetpage?p=$counter&page=showallusers'>$counter</a>";
                            }
                        }
                    }
                }

                // Next
                if ($page < $counter - 1) {
                    $paginate.= "<a href='$targetpage?p=$next&page=showallusers'>next</a>";
                } else {
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
